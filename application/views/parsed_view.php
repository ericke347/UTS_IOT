<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Parsed JSON Data View</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h1>Data JSON yang Diparsing</h1>
    <div id="parsedData"></div>

    <script>
        $(document).ready(function() {
            // Mendapatkan data JSON dari endpoint backend yang difilter
            $.getJSON("http://localhost/uts_iot/api/filtered_sensor_data", function(data) {
                let html = '';

                data.forEach(function(item) {
                    html += `<p>Bulan: ${item.bulan}, Suhu: ${item.suhu}, Humid: ${item.humid}</p>`;
                });

                $("#parsedData").html(html);
            });
        });
    </script>

</body>

</html>