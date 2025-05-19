{{-- resources/views/debug/phpinfo-temp.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8" />
        <title>PHP Info (Debug Temporaire)</title>
        <style>
            /* Un peu de style pour que ce soit lisible */
            body {
                padding: 15px;
                font-family: sans-serif;
            }
            pre {
                margin: 0;
                font-family: monospace;
            }
            a:link {
                color: #009;
                text-decoration: none;
                background-color: #fff;
            }
            a:hover {
                text-decoration: underline;
            }
            table {
                border-collapse: collapse;
                border: 0;
                width: 934px;
                box-shadow: 1px 2px 3px #ccc;
            }
            .center {
                text-align: center;
            }
            .center table {
                margin: 1em auto;
                text-align: left;
            }
            .center th {
                text-align: center !important;
            }
            td,
            th {
                border: 1px solid #666;
                font-size: 75%;
                vertical-align: baseline;
                padding: 4px 5px;
            }
            h1 {
                font-size: 150%;
            }
            h2 {
                font-size: 125%;
            }
            .p {
                text-align: left;
            }
            .e {
                background-color: #ccf;
                width: 300px;
                font-weight: bold;
            }
            .h {
                background-color: #99c;
                font-weight: bold;
            }
            .v {
                background-color: #ddd;
                max-width: 300px;
                overflow-x: auto;
                word-wrap: break-word;
            }
            .v i {
                color: #999;
            }
            img {
                float: right;
                border: 0;
            }
            hr {
                width: 934px;
                background-color: #ccc;
                border: 0;
                height: 1px;
            }
        </style>
    </head>
    <body>
        <h1>PHP Info (Debug Temporaire - À SUPPRIMER !)</h1>
        <p style="color: red; font-weight: bold">ATTENTION : Cette page expose des informations sensibles. Ne jamais la laisser accessible. Supprimez la route et ce fichier après utilisation !</p>

        <hr />

        <div>
            <?php // Appel direct de phpinfo()
            // Appel direct de phpinfo()
            phpinfo(); ?>
        </div>
    </body>
</html>
