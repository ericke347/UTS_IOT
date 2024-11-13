<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Raw JSON Data View</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <h1>Data JSON Mentah</h1>
    <pre id="rawData"></pre>

    <script>
        $(document).ready(function() {
            // Mendapatkan data JSON mentah dari endpoint backend
            $.getJSON("http://localhost/uts_iot/api/get_sensor_data", function(data) {
                $('#rawData').text(JSON.stringify(data, null, 4));
            });
        });
    </script>

</body>

</html>