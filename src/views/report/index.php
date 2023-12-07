<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario General</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<style>
    body {
        font-size: 12px;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        padding-right: 0px;
        overflow-wrap: break-word;
    }

    table th {
        background-color: #EBEDEF;
        border: solid 1px #ABB2B9;
        text-align: center;
        font-weight: 500;
        line-height: 10px;
    }

    table td {
        overflow-wrap: break-word;
        border: solid 1px #ABB2B9;
        padding: 0 4px;
    }
</style>

<body>
    <h1 class="text-center">INVENTARIO GENERAL DE ARCHIVO</h1>
    <section>
        <div class="row justify-content-end">
            <span class="col-3 d-flex align-items-center justify-content-between">
                <div class="mr-5">Fecha de elaboración:</div>
                <?php
                $date = explode('-', $data->inventory->created_at);
                ?>
                <span class="d-flex">
                    <span class="px-4 py-2 mx-0" style="background-color: #CCD1D1;"><?php echo $date[2] ?></span>
                    <span class="px-4 py-2 mx-0" style="background-color: #F2F4F4;"><?php echo $date[1] ?></span>
                    <span class="px-4 py-2 mx-0" style="background-color: #CCD1D1;"><?php echo $date[0] ?></span>
                </span>
            </span>
        </div>
        <div class="row px-2 py-2" style="background-color: #F2F4F4;">
            <div class="col-9">
                Dependencia: <?php echo $data->inventory->subsecretary_id->name ?>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-between">
                Tipo de archivo:
                <span class="text-center">
                    Archivo de trámite
                </span>
            </div>
        </div>
        <div class="row px-2 py-2">
            <div class="col-9">
                Codificación estructural: <?php echo $data->inventory->inventory_id->code ?>
            </div>
            <div class="col-3 d-flex align-items-center justify-content-between">
                Ubicación física:
                <span class="text-center">
                    Área administrativa
                </span>
            </div>
        </div>
        <div class="row px-2 py-2" style="background-color: #F2F4F4;">
            <div class="col-12">
                Unidad administrativa: <?php echo $data->inventory->administrative_unit_id->name ?>
            </div>
        </div>

        <div class="row">
            <span class="col-3 px-4 py-2" style="background-color: #05AEB3; color: white; font-size: 14px; font-weight: 600;">Fondo documental:</span>
            <span class="col-3 px-4 py-2" style="background-color: white;"><?php echo $data->inventory->subsecretary_id->name ?></span>
            <span class="col-3 px-4 py-2" style=" background-color: #05AEB3; color: white; font-size: 14px; font-weight: 600;">Subfondo:</span>
            <span class="col-3 px-4 py-2" style="background-color: white;"><?php echo $data->inventory->administrative_unit_id->name ?></span>
        </div>
    </section>
    <table>
        <thead>
            <tr>
                <th rowspan="2"> Número progresivo </th>
                <th rowspan="2"> Seccion </th>
                <th rowspan="2" style="min-width: 100px;"> Serie y/o subserie documental </th>
                <th rowspan="2"> Número de expediente </th>
                <th rowspan="2" style="min-width: 270px;"> Fórmula clasificadora del expediente </th>
                <th rowspan="2" style="width: 250px;"> Nombre del expediente </th>
                <th rowspan="2" style="min-width:50px ;"> Total de legajos</th>
                <th rowspan="2"> Total de documentos</th>
                <th colspan="2" style="min-width: 250px;"> Fecha de los documentos</th>
                <th rowspan="2" style="max-width: 200px;"> Observaciones</th>
            </tr>
            <tr>
                <th>Primero</th>
                <th>Último</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data->inventory->body as $key => $file) {
                echo "
                        <tr>
                            <td>{$file->no}</td>
                            <td>{$file->section}</td>
                            <td>{$file->serie}</td>
                            <td>{$file->no_ex}</td>
                            <td>{$file->formule}</td>
                            <td>{$file->name}</td>
                            <td>{$file->total_legajos}</td>
                            <td>{$file->total_files}</td>
                            <td style='width:70px'>{$file->files_date[0]}</td>
                            <td style='width:70px'>{$file->files_date[1]}</td>
                            <td style='max-width: 160px; width: 200px;'>{$file->observations}</td>
                        </tr>
                        ";
            }
            ?>

        </tbody>
    </table>
    <div style="margin-top: 280px;">
        <div class="row d-flex justify-content items-center">
            <div class="col-6 text-center">
                <span style="font-weight: bold;">
                    Responsable de Archivo
                </span>
            </div>
            <div class="col-6 text-center">
                <span style="font-weight: bold;">
                    Titular
                </span>
            </div>
        </div>
    </div>
</body>

</html>