<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario General</title>
</head>
<style>
    .body {
        font-size: 11px;
        font-family: Aroal, sans-serif;
    }

    table {
        border-collapse: collapse;
        width: 100%;
        padding-right: 0px;
        overflow-wrap: break-word;
    }

    .table th {
        font-weight: lighter;
        background-color: #EBEDEF;
        border: solid 1px #ABB2B9;
    }

    table td {
        font-weight: lighter;
        overflow-wrap: break-word;
        border: solid 1px #ABB2B9;
    }
</style>

<body class="body">
    <main style="position: relative;">
        <div style="position: absolute; top: -20px; right: 0px; z-index: 5000;">
            <!-- <img src="https://retys.edomex.gob.mx/img/h3.png" alt="EdoMex" height="50" width="150"> -->
        </div>
        <h1 style="text-align: center; font-weight: bold;">INVENTARIO GENERAL DE ARCHIVO</h1>
        <section>
            <div style="padding: 0px 8px; vertical-align: middle; width: 100%; text-align: right; margin-bottom: -2px;">
                <div style="display: inline-block; vertical-align: middle;">
                    Fecha de elaboración:
                    <div style="display: inline-block; background-color: #EBEDEF; vertical-align: middle;">
                        <?php
                        $date = explode('-', $data->inventory->created_at);
                        ?>
                        <div style="display: inline-block; vertical-align: middle; margin-bottom: -5px; padding: 5.5px 10px; background-color: #B2BABB;"><?php echo $date[2] ?></div>
                        <div style="display: inline-block; vertical-align: middle; padding: 8px 10px; margin-bottom: -5px;"><?php echo $date[1] ?></div>
                        <div style="display: inline-block; vertical-align: middle; margin-bottom: -5px; padding: 5.5px 10px; background-color: #B2BABB;"><?php echo $date[0] ?></div>
                    </div>
                </div>
            </div>
            <div style="background-color: #EBEDEF; padding: 5px 4px; vertical-align: middle; width: 100%;">
                <div style="display: inline-block; width: 70%; vertical-align: middle; ">
                    Dependencia: <?php echo $data->inventory->subsecretary_id->name ?>
                </div>
                <div style="display: inline-block; vertical-align: middle; ">
                    Tipo de archivo: Archivo de trámite
                </div>
            </div>
            <div style="padding: 5px 4px; width: 100%;">
                <div style="display: inline-block; width: 70%; vertical-align: middle; ">
                    Codificación estructural: <?php echo $data->inventory->inventory_id->code ?>
                </div>
                <div style="display: inline-block; vertical-align: middle; text-align: right;  ">
                    Ubicación física: Área administrativa
                </div>
            </div>
            <div style="background-color: #EBEDEF; padding: 5px 4px; vertical-align: middle;  width: 100%;">
                <div style="display: inline-block; width: 70%;">
                    Unidad administrativa: <?php echo $data->inventory->administrative_unit_id->name ?>
                </div>
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="text-align: left; font-weight: lighter;  width: 100%; background-color: #05AEB3; color: white; padding: 5px 3px;">Fondo documental:</th>
                        <th style="text-align: left; font-weight: lighter;  width: 100%; background-color: white; padding: 5px 0; padding: 5px 3px;"><?php echo $data->inventory->subsecretary_id->name ?></th>
                        <th style="text-align: left; font-weight: lighter;  width: 100%;  background-color: #05AEB3; color: white; padding: 5px 3px;">Subfondo:</th>
                        <th style="text-align: left; font-weight: lighter;  width: 100%; background-color: white; padding: 5px 0; padding: 5px 3px;"><?php echo $data->inventory->administrative_unit_id->name ?></th>
                    </tr>
                </thead>
            </table>
            <span style="background-color: #05AEB3; color: white; padding: 5px 0; width: 100%;">

            </span>
            <span style="width: 100%;">

            </span>
            <span style="background-color: #05AEB3; color: white; padding: 5px 0; width: 100%;">

            </span>
            <span style="width: 100%;">

            </span>
            </div>
        </section>
        <table class="table">
            <thead>
                <tr>
                    <th rowspan="2"> Número progresivo </th>
                    <th rowspan="2"> Seccion </th>
                    <th rowspan="2" style="width: 120px;"> Serie y/o subserie documental </th>
                    <th rowspan="2"> Número de expediente </th>
                    <th rowspan="2"> Fórmula clasificadora del expediente </th>
                    <th rowspan="2" style="width: 250px;"> Nombre del expediente </th>
                    <th rowspan="2"> Total de legajos</th>
                    <th rowspan="2"> Total de documentos</th>
                    <th colspan="2" style="width: 350px;"> Fecha de los documentos</th>
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
    </main>
</body>

</html>