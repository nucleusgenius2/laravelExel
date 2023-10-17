<?php


namespace App\Http\Controllers;


use App\Jobs\ParserExel;
use App\Models\Rows;
use App\Traits\ResponseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExelController
{
    use ResponseController;

    /**
     * parsing the date from the excel document to the database
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xls,xlsx|max:25600',
        ]);

        if ($validated->fails()) {
            $this->text = $validated ->errors();
            log::info('122');
        } else {
            $data = $validated->valid();

            $spreadsheet = IOFactory::load($data['file']->getRealPath());

            $sheet = $spreadsheet->getActiveSheet ();

            $data = $sheet->toArray(); //вложенный массив всех данных документа

            $dataBd = [];

            if (!empty($data)) {
                for ($i=1; $i<count($data); $i++) {

                    if ( isset($data[$i][1]) ) {
                        $dataBd[] = [
                            'name' => $data[$i][1],
                            'date_row' => $data[$i][2]
                        ];
                    }
                }
            }

            Redis::set('name2', '2');

            ParserExel::dispatch($dataBd)->onQueue('exel');

            $this->status = 'success';
        }

        return $this->responseJsonApi();
    }


    public static function progressUpload(int $progress)
    {

    }


    /**
     * get exel data
     * @param Request $request
     * @return JsonResponse
     */
    public function get(Request $request): JsonResponse
    {
        $validated = Validator::make(['page' => $request->page], [
            'page' => 'required|integer|min:1',
        ]);

        if ($validated->fails()) {
            $this->text = $validated->errors();
        } else {
            $data = $validated->valid();

            $exelData = Rows::paginate(3000, ['*'], 'page', $data['page']);

            if (count($exelData) > 0) {
                $this->status = 'success';
                $this->json = $exelData;
            } else {
                $this->text = 'Запрашиваемой страницы не существует';
            }
        }

        return $this->responseJsonApi();
    }
}
