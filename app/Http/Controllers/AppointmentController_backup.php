public function publicStore(Request $request)
    {
        $validated = $request->validate([

            /*
             * CLIENTE
             */
            'name' => [
                'required',
                'string',
                'max:255'
            ],

            'phone' => [
                'required',
                'string',
                'max:20'
            ],

            'email' => [
                'nullable',
                'email',
                'max:255'
            ],


            /*
             * VEHÍCULO
             */
            'brand' => [
                'required',
                'string',
                'max:100'
            ],

            'model' => [
                'required',
                'string',
                'max:100'
            ],

            'year' => [
                'required',
                'integer'
            ],

            'engine' => [
                'required',
                'string',
                'max:100'
            ],

            'color' => [
                'required',
                'string',
                'max:100'
            ],

            'plates' => [
                'nullable',
                'string',
                'max:50'
            ],

            'mileage' => [
                'required',
                'numeric',
                'min:0'
            ],


            /*
             * CITA
             */
            'appointment_date' => [
                'required',
                'date'
            ],

            'appointment_time' => [
                'required'
            ],

            'service_type' => [
                'required',
                'string',
                'max:255'
            ],


            /*
             * OBSERVACIONES / FALLA
             *
             * Mantenemos "description" porque el
             * formulario público actual ya puede
             * estar enviando ese nombre.
             */
            'description' => [
                'nullable',
                'string',
                'max:1000'
            ],

        ]);


        /*
         * ==============================
         * CREAR CLIENTE
         * ==============================
         */

        $client = Client::create([

            'name' => $validated['name'],

            'phone' => $validated['phone'],

            'email' => $validated['email'] ?? null,

        ]);


        /*
         * ==============================
         * CREAR VEHÍCULO
         * ==============================
         */

        $vehicle = Vehicle::create([

            'client_id' => $client->id,

            'brand' => $validated['brand'],

            'model' => $validated['model'],

            'year' => $validated['year'],

            'engine' => $validated['engine'],

            'color' => $validated['color'],

            'plates' => $validated['plates'] ?? null,

            'mileage' => $validated['mileage'],

        ]);


        /*
         * ==============================
         * CREAR CITA
         * ==============================
         */

        $appointment = Appointment::create([

            'client_id' => $client->id,

            'vehicle_id' => $vehicle->id,

            'mechanic_id' => null,

            'service_type' => $validated['service_type'],

            'appointment_date' =>
                $validated['appointment_date'],

            'appointment_time' =>
                $validated['appointment_time'],

            'status' => 'pendiente',

            /*
             * "description" del formulario
             * se guarda en la columna "notes"
             * de appointments.
             */
            'notes' => $validated['description'] ?? null,

        ]);


        /*
         * ==============================
         * GENERAR FOLIO
         * ==============================
         */

        $appointment->folio =
            'AM-' .
            now()->format('Y') .
            '-' .
            str_pad(
                $appointment->id,
                6,
                '0',
                STR_PAD_LEFT
            );

        $appointment->save();


        /*
         * ==============================
         * RESPUESTA
         * ==============================
         */

        return response()->json([

            'success' => true,

            'folio' => $appointment->folio,

            'name' => $client->name,

            'date' => $appointment->appointment_date,

            'time' => $appointment->appointment_time,

        ]);
    }