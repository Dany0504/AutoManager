<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $reporte = $request->query('reporte', 'ingresos');

        $reportesPermitidos = [
            'ingresos',
            'ordenes',
            'servicios',
            'mecanicos',
        ];

        if (!in_array($reporte, $reportesPermitidos, true)) {
            $reporte = 'ingresos';
        }

        // Fechas de los últimos seis meses, incluido el actual.
        $meses = collect(range(5, 0))
            ->map(function ($numero) {
                $fecha = now()->startOfMonth()->subMonths($numero);

                return [
                    'clave' => $fecha->format('Y-m'),
                    'nombre' => $fecha->locale('es')->translatedFormat('M Y'),
                ];
            });

        // Montos estimados y cantidad de citas por mes.
        $resumenMensual = Appointment::query()
            ->selectRaw("DATE_FORMAT(appointment_date, '%Y-%m') AS mes")
            ->selectRaw('COUNT(*) AS total_ordenes')
            ->selectRaw('COALESCE(SUM(estimated_cost), 0) AS monto_estimado')
            ->whereDate(
                'appointment_date',
                '>=',
                now()->startOfMonth()->subMonths(5)->toDateString()
            )
            ->groupBy('mes')
            ->get()
            ->keyBy('mes');

        $ingresos = $meses->map(function ($mes) use ($resumenMensual) {
            $datos = $resumenMensual->get($mes['clave']);

            $ordenes = (int) ($datos->total_ordenes ?? 0);
            $monto = (float) ($datos->monto_estimado ?? 0);

            return [
                'mes' => $mes['nombre'],
                'monto' => $monto,
                'ordenes' => $ordenes,
                'promedio' => $ordenes > 0 ? $monto / $ordenes : 0,
            ];
        });

        // Cantidad de citas agrupadas por estado.
        $ordenes = Appointment::query()
            ->select('status')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get()
            ->map(function ($fila) {
                return [
                    'nombre' => ucfirst(
                        str_replace('_', ' ', $fila->status)
                    ),
                    'total' => (int) $fila->total,
                ];
            });

        // Servicios más solicitados.
        $servicios = Appointment::query()
            ->select('service_type')
            ->selectRaw('COUNT(*) AS total')
            ->groupBy('service_type')
            ->orderByDesc('total')
            ->get()
            ->map(function ($fila) {
                return [
                    'nombre' => $fila->service_type,
                    'total' => (int) $fila->total,
                ];
            });

        // Cantidad de citas asignadas a cada mecánico.
        $mecanicos = User::query()
            ->where('rol', 'mecanico')
            ->leftJoin(
                'appointments',
                'users.id',
                '=',
                'appointments.mechanic_id'
            )
            ->select(
                'users.id',
                'users.name'
            )
            ->selectRaw('COUNT(appointments.id) AS total')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total')
            ->get()
            ->map(function ($fila) {
                return [
                    'nombre' => $fila->name,
                    'total' => (int) $fila->total,
                ];
            });

        $datos = match ($reporte) {
            'ordenes' => $ordenes,
            'servicios' => $servicios,
            'mecanicos' => $mecanicos,
            default => $ingresos,
        };

        $titulo = match ($reporte) {
            'ordenes' => 'Órdenes por estado',
            'servicios' => 'Servicios más solicitados',
            'mecanicos' => 'Desempeño de mecánicos',
            default => 'Montos estimados por mes',
        };

        return view('admin.reportes.index', compact(
            'reporte',
            'datos',
            'titulo'
        ));
    }

    public function exportar(Request $request)
    {
        $reporte = $request->query('reporte', 'ingresos');

        if (!in_array(
            $reporte,
            ['ingresos', 'ordenes', 'servicios', 'mecanicos'],
            true
        )) {
            abort(404);
        }

        // Reutilizamos los cálculos del reporte.
        $respuesta = $this->index(
            new Request(['reporte' => $reporte])
        );

        $datos = $respuesta->getData()['datos'];

        $nombreArchivo = 'reporte_' . $reporte . '_' .
            now()->format('Ymd_His') . '.csv';

        return response()->streamDownload(function () use ($datos, $reporte) {
            $salida = fopen('php://output', 'w');

            // BOM para que Excel reconozca los acentos.
            fwrite($salida, "\xEF\xBB\xBF");

            if ($reporte === 'ingresos') {
                fputcsv(
                    $salida,
                    ['Mes', 'Monto estimado', 'Ordenes', 'Ticket promedio estimado']
                );

                foreach ($datos as $fila) {
                    fputcsv($salida, [
                        $fila['mes'],
                        $fila['monto'],
                        $fila['ordenes'],
                        $fila['promedio'],
                    ]);
                }
            } else {
                fputcsv($salida, ['Concepto', 'Total']);

                foreach ($datos as $fila) {
                    fputcsv($salida, [
                        $fila['nombre'],
                        $fila['total'],
                    ]);
                }
            }

            fclose($salida);
        }, $nombreArchivo, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
