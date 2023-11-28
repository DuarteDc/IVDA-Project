<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Inventario General</title>
</head>
<style>
    .body {
        font-size: 12px;
    }

    .gary-row {
        background-color: #EBEDEF;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 6px;
        font-size: 12px;
    }

    .white-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 6px;
    }

    .first-head-table {
        width: 100%;
        display: flex;
        justify-content: space-between;

    }

    .first-head-table>span {
        width: 100%;
        padding: 10px 6px;
    }

    .table {
        width: 100%;
        font-size: 12px;
    }
    table{
        border-collapse: collapse;
    }

    table th {
        background-color: #EBEDEF;
        font-weight: lighter;
        border: solid 1px #ABB2B9;
    }
    table td {
        font-weight: lighter;
        border: solid 1px #ABB2B9;
    }
</style>

<body class="body">
    <main>
        <h1 style="text-align: center; font-weight: bold;">INVENTARIO GENERAL DE ARCHIVO</h1>
        <section>
            <div class="gary-row">
                <span>
                    <p>Dependencia:</p>
                </span>
                <span>
                    <p>Tipo de archivo:</p>
                </span>
            </div>
            <div class="white-row">
                <span>
                    <p>Codificación estructural:</p>
                </span>
                <span>
                    <p>Tipo de archivo:</p>
                </span>
            </div>
            <div class="gary-row">
                <span>
                    <p>Unidad administrativa:</p>
                </span>
            </div>
            <div class="first-head-table">
                <span style="background-color: #05AEB3; color: white;">
                    Fondo documental:
                </span>
                <span>
                    Secretaría de Finanzas (SF)
                </span>
                <span style="background-color: #05AEB3; color: white;">
                    Subfondo:
                </span>
                <span>
                    Oficina del C. Secretario y Áreas Staff (OSF)
                </span>
            </div>
        </section>
        <table class="table">
            <thead>
                <tr>
                    <th> Número progresivo </th>
                    <th> Seccion </th>
                    <th> Serie y/o subserie documental </th>
                    <th> Número de expediente </th>
                    <th> Fórmula clasificadora del expediente </th>
                    <th> Nombre del expediente </th>
                    <th> Total de legajos</th>
                    <th> Total de documentos</th>
                    <th> Fecha de los documentos</th>
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