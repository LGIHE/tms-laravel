<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Sheets;
use Illuminate\Http\Request;
// use Revolution\Google\Sheets\Facades\Sheets;
use Google\Client;
use Google\Service\Sheets;

class GoogleSheetsController extends Controller
{
    public function getSheetData(Request $request)
    {
        // $sheetUrl = $request->input('sheetUrl');
        $sheetUrl = 'https://docs.google.com/spreadsheets/d/1j6-bx3ETwzvq395g08ySwV2ECvZWV7ME/edit?usp=sharing&ouid=105914784750922163295&rtpof=true&sd=true';

        // Validate input link to ensure it's a valid Google Sheets shared link
        // ... (implement validation logic)

        try {
            $client = $this->createGoogleClient();
            $service = new Google_Service_Sheets($client);

            $spreadsheetId = $this->getSpreadsheetIdFromUrl($sheetUrl);
            $range = 'Teachers Database!B5:B446'; // Adjust the range as needed

            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            return response()->json(['Teacher count'=> count($values)]); // Or process and return data as needed
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function createGoogleClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('LGF-TMS');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig(storage_path('app/google_service_credentials.json'));

        // Use service account authorization for server-side access
        $client->useApplicationDefaultCredentials();

        return $client;
    }

    private function getSpreadsheetIdFromUrl($sheetUrl)
    {
        // Extract the spreadsheet ID from the shared link's URL
        $urlParts = parse_url($sheetUrl);

        // Attempt to match the spreadsheet ID from the path or query string
        preg_match('/\/spreadsheets\/d\/([^\/]+)/', $urlParts['path'], $matches);

        if (!empty($matches[1])) {
            // If the ID is found in the path
            return $matches[1];
        } elseif (isset($urlParts['query'])) {
            // If the 'key' parameter exists in the query string
            parse_str($urlParts['query'], $query);
            if (isset($query['key'])) {
                return $query['key'];
            }
        }

        // If no match is found
        throw new \Exception('Unable to extract spreadsheet ID from the provided URL');
    }

    public function test(){
        $sheets = Sheets::spreadsheet('1j6-bx3ETwzvq395g08ySwV2ECvZWV7ME')->sheet('SUMMARIES')->all();
        dd($sheets);

    }

    public function getSheetDataFunc() {
        $client = new Client();
        $client->setAuthConfig('/Users/caleb/LGIHE/Dev/tms-laravel/storage/app/google_service_credentials.json');
        $client->addScope(Sheets::SPREADSHEETS_READONLY);

        $service = new Sheets($client);
        $spreadsheetId = '1j6-bx3ETwzvq395g08ySwV2ECvZWV7ME';
        $range = 'Sheet1!A1:E';
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);

        return $response->getValues();
    }

    public function importSheet(Request $request)
    {
        // $request->validate([
        //     'sheet_link' => 'required|url'
        // ]);

        // $sheetUrl = $request->input('sheet_link');

        $sheetUrl = "https://docs.google.com/spreadsheets/d/1j6-bx3ETwzvq395g08ySwV2ECvZWV7ME/edit?usp=sharing&ouid=105914784750922163295&rtpof=true&sd=true";

        // Extract the spreadsheet ID from the URL
        preg_match('/\/spreadsheets\/d\/([a-zA-Z0-9-_]+)/', $sheetUrl, $matches);
        if (!isset($matches[1])) {
            return redirect()->back()->with('error', 'Invalid Google Sheets link');
        }
        $spreadsheetId = $matches[1];

        // Initialize Google Client
        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/credentials.json'));
        $client->addScope(Google_Service_Sheets::SPREADSHEETS_READONLY);

        $service = new Google_Service_Sheets($client);

        // Read data from the first sheet
        $range = 'Sheet1!A1:E'; // Adjust the range as needed
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();

        if (empty($values)) {
            return redirect()->back()->with('error', 'No data found in the Google Sheet');
        }

        return view('sheet-data', ['data' => $values]);
    }

}
