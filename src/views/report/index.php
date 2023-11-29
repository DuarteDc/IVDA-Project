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
    }

    .table th {
        font-weight: lighter;
        background-color: #EBEDEF;
        border: solid 1px #ABB2B9;
    }

    table td {
        font-weight: lighter;
        border: solid 1px #ABB2B9;
    }
</style>

<body class="body">
    <main style="position: relative;">
        <div style="position: absolute;">
        </div>
        <h1 style="text-align: center; font-weight: bold;">INVENTARIO GENERAL DE ARCHIVO</h1>
        <section>
            <div style="background-color: white; padding: 5px 4px; vertical-align: middle;">
                <div style="display: inline-block; width: 77%;">
                </div>
                <div style="display: inline-block;">
                    Fecha de elaboración:
                    <div style="display: inline-block; vertical-align: middle;">
                        <?php
                        $date = explode('-', $data->inventory->created_at);
                        ?>
                        <div style="display: inline-block;  padding: 5px 10px; background-color: #EBEDEF; vertical-align: bottom;"><?php echo $date[2] ?></div>
                        <div style="display: inline-block;  padding: 5px 10px; background-color: #EBEDEF; vertical-align: bottom;"><?php echo $date[1] ?></div>
                        <div style="display: inline-block;  padding: 5px 10px; background-color: #EBEDEF; vertical-align: bottom;"><?php echo $date[0] ?></div>
                    </div>
                </div>
            </div>
            <div style="background-color: #EBEDEF; padding: 5px 4px; vertical-align: middle;">
                <div style="display: inline-block; width: 70%;">
                    Dependencia: <?php echo $data->inventory->subsecretary_id->name ?>
                </div>
                <div style="display: inline-block; ">
                    Tipo de archivo: Archivo de trámite
                </div>
            </div>
            <div style="padding: 5px 4px; vertical-align: middle;">
                <div style="display: inline-block; width: 70%;">
                    Codificación estructural: <?php echo $data->inventory->inventory_id->code ?>
                </div>
                <div style="display: inline-block; ">
                    Ubicación física: Área administrativa
                </div>
            </div>
            <div style="background-color: #EBEDEF; padding: 5px 4px; vertical-align: middle;">
                <div style="display: inline-block; width: 70%;">
                    Unidad administrativa: <?php echo $data->inventory->administrative_unit_id->name ?>
                </div>
            </div>
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th style="font-weight: lighter;  width: 100%; background-color: #05AEB3; color: white; padding: 5px 0;">Fondo documental:</th>
                        <th style="font-weight: lighter;  width: 100%; background-color: white;"><?php echo $data->inventory->subsecretary_id->name ?></th>
                        <th style="font-weight: lighter;  width: 100%;  background-color: #05AEB3; color: white; padding: 5px 0;">Subfondo:</th>
                        <th style="font-weight: lighter;  width: 100%; background-color: white;"><?php echo $data->inventory->administrative_unit_id->name ?></th>
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
                    <th> Número progresivo </th>
                    <th> Seccion </th>
                    <th style="width: 120px;"> Serie y/o subserie documental </th>
                    <th> Número de expediente </th>
                    <th> Fórmula clasificadora del expediente </th>
                    <th style="width: 300px;"> Nombre del expediente </th>
                    <th> Total de legajos</th>
                    <th> Total de documentos</th>
                    <th colspan="2" style="width: 350px; padding: 0;">
                        Fecha de los documentos
                    </th>
                    <th> Observaciones</th>
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
                            <td>{$file->files_date[0]}</td>
                            <td>{$file->files_date[1]}</td>
                            <td>{$file->observations}</td>
                        </tr>
                        ";
                }
                ?>

            </tbody>
        </table>
    </main>
</body>

</html>