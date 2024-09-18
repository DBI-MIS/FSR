<?php

namespace App\Filament\Resources\FsrResource\Pages;

use App\Filament\Resources\FsrResource;
use Carbon\Carbon;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Collection;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;

class ListFsrs extends ListRecords
{
    protected static string $resource = FsrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color("primary")
                ->slideOver()
                ->processCollectionUsing(function (string $modelClass, Collection $collection) {
                    $collection->each(function ($row) use ($modelClass) {
                        

                        $timeArrived = Carbon::parse($row['time_arrived'])->format('H:i:s');
                        $timeCompleted = Carbon::parse($row['time_completed'])->format('H:i:s');
                        $jobDateStarted = Carbon::parse($row['job_date_started'])->format('Y-m-d');
                        $jobDateFinished = Carbon::parse($row['job_date_finished'])->format('Y-m-d');
                        $attendedToString = $row['attended_to'];
                        $attendedToArray = explode(',', $attendedToString);

                        $modelClass::create([
                            'fsr_no' => $row['fsr_no'],
                            'user_id' => $row['user_id'],
                            'time_arrived' => $timeArrived,
                            'time_completed' => $timeCompleted,
                            'job_date_started' =>  $jobDateStarted,
                            'job_date_finished' =>  $jobDateFinished,
                            'project_id' => $row['project_id'],
                            'attended_to' => $attendedToArray,
                            'concerns' => $row['concerns'],
                            'service_rendered' => $row['service_rendered'],
                            'recommendation' => $row['recommendation'],
                            'response_time' => $row['response_time'],
                            'response_time_rate' => $row['response_time_rate'],
                            'service_time' => $row['service_time'],
                            'service_time_rate' => $row['service_time_rate'],
                            'resolution_time' => $row['resolution_time'],
                            'resolution_time_rate' => $row['resolution_time_rate'],
                            'suggestions' => $row['suggestions'],
                            'encoder' => $row['encoder'],
                            'actual_voltage_v1' => $row['actual_voltage_v1'],
                            'actual_voltage_v2' => $row['actual_voltage_v2'],
                            'actual_voltage_v3' => $row['actual_voltage_v3'],
                            'actual_amperage_v1' => $row['actual_amperage_v1'],
                            'actual_amperage_v2' => $row['actual_amperage_v2'],
                            'actual_amperage_v3' => $row['actual_amperage_v3'],
                            'voltage_imbalance' => $row['voltage_imbalance'],
                            'current_imbalance' => $row['current_imbalance'],
                            'control_voltage' => $row['control_voltage'],
                            'reading_for' => $row['reading_for'],
                            'compressor_type' => $row['compressor_type'],
                            'refrigerant_type' => $row['refrigerant_type'],
                            'suction_pressure1' => $row['suction_pressure1'],
                            'suction_pressure2' => $row['suction_pressure2'],
                            'suction_pressure3' => $row['suction_pressure3'],
                            'suction_pressure4' => $row['suction_pressure4'],
                            'discharge_pressure1' => $row['discharge_pressure1'],
                            'discharge_pressure2' => $row['discharge_pressure2'],
                            'discharge_pressure3' => $row['discharge_pressure3'],
                            'discharge_pressure4' => $row['discharge_pressure4'],
                            'oil_pressure1' => $row['oil_pressure1'],
                            'oil_pressure2' => $row['oil_pressure2'],
                            'oil_pressure3' => $row['oil_pressure3'],
                            'oil_pressure4' => $row['oil_pressure4'],
                            'suction_temp1' => $row['suction_temp1'],
                            'suction_temp2' => $row['suction_temp2'],
                            'suction_temp3' => $row['suction_temp3'],
                            'suction_temp4' => $row['suction_temp4'],
                            'discharge_temp1' => $row['discharge_temp1'],
                            'discharge_temp2' => $row['discharge_temp2'],
                            'discharge_temp3' => $row['discharge_temp3'],
                            'discharge_temp4' => $row['discharge_temp4'],
                            'liquid_temp1' => $row['liquid_temp1'],
                            'liquid_temp2' => $row['liquid_temp2'],
                            'liquid_temp3' => $row['liquid_temp3'],
                            'liquid_temp4' => $row['liquid_temp4'],
                            'oil_temp1' => $row['oil_temp1'],
                            'oil_temp2' => $row['oil_temp2'],
                            'oil_temp3' => $row['oil_temp3'],
                            'oil_temp4' => $row['oil_temp4'],
                            'discharge_superheat1' => $row['discharge_superheat1'],
                            'discharge_superheat2' => $row['discharge_superheat2'],
                            'discharge_superheat3' => $row['discharge_superheat3'],
                            'discharge_superheat4' => $row['discharge_superheat4'],
                            'wcc_cooler_temp' => $row['wcc_cooler_temp'],
                            'wcc_condenser_temp' => $row['wcc_condenser_temp'],
                            'acc_cooler_temp' => $row['acc_cooler_temp'],
                            'acc_ambient_temp' => $row['acc_ambient_temp'],
                            'pressure_cooler_water_in' => $row['pressure_cooler_water_in'],
                            'pressure_condenser_water_in' => $row['pressure_condenser_water_in'],
                            'pressure_cooler_water_out' => $row['pressure_cooler_water_out'],
                            'pressure_condenser_water_out' => $row['pressure_condenser_water_out'],
                            'water_pressure_drop_cooler' => $row['water_pressure_drop_cooler'],
                            'water_pressure_drop_condenser' => $row['water_pressure_drop_condenser'],
                            'approach_condenser_cooler_temp' => $row['approach_condenser_cooler_temp'],
                            'approach_condenser_condenser_temp' => $row['approach_condenser_condenser_temp'],
                            'approach_evaporator_cooler_temp' => $row['approach_evaporator_cooler_temp'],
                            'approach_evaporator_condenser_temp' => $row['approach_evaporator_condenser_temp'],
                            'temp_cooler_water_in_air_in' => $row['temp_cooler_water_in_air_in'],
                            'temp_cooler_water_out_air_out' => $row['temp_cooler_water_out_air_out'],
                            'temp_condenser_water_in_air_in' => $row['temp_condenser_water_in_air_in'],
                            'temp_condenser_water_out_air_out' => $row['temp_condenser_water_out_air_out'],
                        ]);
                    });

                    return $collection;
                }),
             // Export Action
            //  ExportAction::make('export')
            //  ->label('Export')
            //  ->icon('heroicon-o-download')
            //  ->color('success')
            //  ->withColumns([
            //      'fsr_no' => 'FSR No.',
            //      'user_id' => 'User ID',
            //      'time_arrived' => 'Time Arrived',
            //      'time_completed' => 'Time Completed',
            //      'job_date_started' => 'Job Date Started',
            //      'job_date_finished' => 'Job Date Finished',
            //      'project_id' => 'Project ID',
            //      'concerns' => 'concerns',
            //      'service_rendered' => 'service_rendered',
            //      'recommendation' => 'recommendation',
            //  ]),
            // ExportAction::make()->exports([
            //     ExcelExport::make()->withColumns([
            //         Column::make('fsr_no'),
            //         Column::make('created_at'),
            //         Column::make('deleted_at'),
            //     ]),
            // ]),
         Actions\CreateAction::make(),
            
        ];
        
    }
}
