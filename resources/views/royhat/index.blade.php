@extends('master')
@section('css')
    .styled-table {
    border-collapse: collapse;
    border-top: 4px solid #0b0b5b;
    margin: 25px 0;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 400px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
    font-weight: bold;
    }

    .styled-table th,
    .styled-table td {
    padding: 12px 15px;

    }
    .styled-table tbody tr {
    border-bottom: 1px solid #dddddd;

    }
    .styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
    }
    .styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #0b0b5b;

    }

@endsection
@section('content')

    <div style="box-shadow: 0px 0px 5px 5px #b1b1e3" class="card container pt-3 overflow-auto" >
        <div class="d-flex align-itmes-center justify-content-between">
            <h2 class="card-title" style="color: #050c5d">Barcha qarzdorlar ro'yhati </h2>
            <div class="d-flex">
            <button class="btn m-1" onclick="xabar()"  style="background-color: #4118ba; color: white; font-weight: bold"> <i class="fa fa-paper-plane"></i> Tanlangan qarzdorlarga SMS yuborish</button>
            <button class="btn m-1" id="exportBtn" style="background-color: #041b62; color: white; font-weight: bold"> <i class="fa fa-file-excel"></i> Excel</button>
            </div>
        </div>
        <form id="form1" action="{{route('tanlanganlara_jonat')}}" method="post">
        <table id="table1" class="tablesorter table  styled-table">
            <thead class="text h4">
            <tr class="">
                <th style="font-size: 14px;" class="text-center"> <input id="select-all" style=" margin-left: 15px; width: 20px;height: 20px;" type="checkbox"></th>
                <th>Ism</th>
                <th>Qarz</th>
                <th>Telefon qaram</th>
                <th>Qaytarish muddati</th>
                <th>SMS soni</th>
                <th>Tashkilot nomi</th>
            </tr>
            </thead>
            <tbody>

                @csrf
                <input type="hidden" name="smscheck" required id="smscheck">
            @foreach($qarzdorlar as $item)
                @if($item['return_date']>date('Y-m-d') )
                <tr>
                    <td class="text-center yashil"><input class="checkbox" name="qarzdorlar[{{$item->id}}]" style="width: 20px;height: 20px;" type="checkbox"></td>
                    <td class=" yashil">{{$item->name}} @if($item->type==2) <span class="badge bg-primary">Madrasa</span> @endif</td>
                    <td class=" yashil">{{$item->debt}}</td>
                    <td class=" yashil">{{$item->phone}}</td>
                    <td class=" yashil">{{$item->return_date}}</td>
                    <td class=" yashil">{{$item->sms_count}}</td>
                    <td class="yashil">{{ $item->korxona ? $item->korxona->name : '' }}</td>
                </tr>
                @endif
                @if($item['return_date']<date('Y-m-d') )
                <tr>
                    <td class="text-center qizil"><input class="checkbox" name="qarzdorlar[{{$item->id}}]" style="width: 20px;height: 20px;" type="checkbox"></td>
                    <td class=" qizil">{{$item->name}} @if($item->type==2) <span class="badge bg-primary">Madrasa</span> @endif</td>
                    <td class=" qizil">{{$item->debt}}</td>
                    <td class=" qizil">{{$item->phone}}</td>
                    <td class=" qizil">{{$item->return_date}}</td>
                    <td class=" qizil">{{$item->sms_count}}</td>
                    <td class="qizil">{{ $item->korxona ? $item->korxona->name : '' }}</td>
                </tr>
                @endif
                @if($item['return_date']==date('Y-m-d') )
                <tr>
                    <td class="text-center sariq"><input class="checkbox" name="qarzdorlar[{{$item->id}}]" style="width: 20px;height: 20px;" type="checkbox"></td>
                    <td class=" sariq">{{$item->name}} @if($item->type==2) <span class="badge bg-primary">Madrasa</span> @endif</td>
                    <td class=" sariq">{{$item->debt}}</td>
                    <td class=" sariq">{{$item->phone}}</td>
                    <td class=" sariq">{{$item->return_date}}</td>
                    <td class=" sariq">{{$item->sms_count}}</td>
                    <td class="sariq">{{ $item->korxona ? $item->korxona->name : '' }}</td>
                </tr>
                @endif

            @endforeach
                </div>


            </tbody>
        </table>
        </form>
    </div>

@endsection
@section('js')
    <script>

        function xabar() {
            $('#form1').submit();
        }
        $(document).ready(function() {
            $(".qizil").css("background-color", "#ef2d72");
            $(".yashil").css("background-color", "#1bb3a1");
            $(".sariq").css("background-color", "#ecc127");
        $('#select-all').click(function(event) {

            if(this.checked) {
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;
                });
            }
        });

        });
    </script>
    <script src="https://unpkg.com/xlsx/dist/xlsx.full.min.js"></script>
    <script>
        document.getElementById('exportBtn').addEventListener('click', function() {
            // Get the table element
            var table = document.getElementById('table1');

            // Get the table header row
            var headerRow = table.querySelector('thead tr');

            // Get all the data rows
            var dataRows = Array.from(table.querySelectorAll('tbody tr'));

            // Remove "Madrasa" from the first column of each data row
            dataRows.forEach(function(row) {
                var firstCell = row.querySelector('td:first-child');
                firstCell.textContent = firstCell.textContent.replace('Madrasa', '');
            });

            // Add a new "Turi" column to each data row and update its value
            dataRows.forEach(function(row) {
                var turiCell = document.createElement('td');
                var containsMadrasa = Array.from(row.getElementsByTagName('td')).some(function(cell) {
                    return cell.textContent.includes('Madrasa');
                });
                turiCell.textContent = containsMadrasa ? 'Madrasadan' : 'Boshqa';
                row.appendChild(turiCell);
            });

            // Sort the data rows based on the "Turi" column value
            dataRows.sort(function(a, b) {
                var aTuri = a.lastElementChild.textContent;
                var bTuri = b.lastElementChild.textContent;
                if (aTuri === 'Madrasadan' && bTuri !== 'Madrasadan') {
                    return -1; // a comes before b
                } else if (aTuri !== 'Madrasadan' && bTuri === 'Madrasadan') {
                    return 1; // b comes before a
                } else {
                    return 0; // preserve the order
                }
            });

            // Create a new table with the header row and sorted data rows
            var sortedTable = document.createElement('table');
            sortedTable.appendChild(headerRow.cloneNode(true));
            dataRows.forEach(function(row) {
                sortedTable.appendChild(row.cloneNode(true));
            });

            // Convert the sorted table to a workbook object
            var workbook = XLSX.utils.table_to_book(sortedTable);

            // Convert the workbook to an Excel file
            var excelFile = XLSX.write(workbook, { bookType: 'xlsx', type: 'array' });

            // Create a Blob object from the file data
            var blob = new Blob([excelFile], { type: 'application/octet-stream' });

            // Create a temporary anchor element
            var anchor = document.createElement('a');
            anchor.href = URL.createObjectURL(blob);
            anchor.download = 'table.xlsx';

            // Programmatically trigger the download
            anchor.click();

            // Clean up
            URL.revokeObjectURL(anchor.href);
            anchor.remove();

            // Remove the "Turi" column from each data row after exporting
            dataRows.forEach(function(row) {
                row.removeChild(row.lastElementChild);
            });

            // Restore the original content of the first column
            dataRows.forEach(function(row) {
                var firstCell = row.querySelector('td:first-child');
                firstCell.textContent = firstCell.textContent.trim(); // remove any leading/trailing spaces
            });
        });

    </script>
    @endsection

