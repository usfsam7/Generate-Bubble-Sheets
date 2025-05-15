 <!DOCTYPE html>
<html dir="rtl" lang="ar" >
<head>
    <meta charset="UTF-8">
    <style>
        /* body { font-family: DejaVu Sans, sans-serif; text-align: right;
            direction: rtl;
            unicode-bidi: embed;
        } */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; font-size: 16px;

        }

    </style>
</head>
<body>
    <h2 style="text-align: center;">  قائمه </h2>
    <table>
        @foreach ($rows as $index => $row)
            <tr>
                @foreach ($row as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
</body>
</html>



