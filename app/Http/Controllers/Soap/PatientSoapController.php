<?php

namespace App\Http\Controllers\Soap;

use App\Models\Patient;

class PatientSoapController
{
    public function handle()
    {
        try {
            // 📌 WSDL
            if (request()->query('wsdl') !== null) {
                return response(
                    file_get_contents(storage_path('app/wsdl/patients.wsdl')),
                    200,
                    ['Content-Type' => 'text/xml']
                );
            }

            // 📌 SOAP Server
            $server = new \SoapServer(
                storage_path('app/wsdl/patients.wsdl'),
                [
                    'cache_wsdl' => WSDL_CACHE_NONE,
                    'exceptions' => true,
                ]
            );

            $server->setObject($this);

            ob_start();
            $server->handle();
            $xml = ob_get_clean();

            return response($xml, 200)
                ->header('Content-Type', 'text/xml');

        } catch (\Throwable $e) {
            // ❌ SIEMPRE XML, NUNCA HTML
            return response(
                '<?xml version="1.0"?>
                <soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                  <soap:Body>
                    <soap:Fault>
                      <faultcode>SOAP-ENV:Server</faultcode>
                      <faultstring>'.$e->getMessage().'</faultstring>
                    </soap:Fault>
                  </soap:Body>
                </soap:Envelope>',
                500,
                ['Content-Type' => 'text/xml']
            );
        }
    }

    // 🔑 MÉTODO SOAP (DEBE COINCIDIR CON EL WSDL)
    public function getPatients()
    {
        return [
            'patients' => Patient::query()
                ->whereNull('deleted_at')
                ->pluck('full_name')
                ->toArray()
        ];
    }
    
}
