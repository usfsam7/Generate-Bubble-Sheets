<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload Excel File</title>
    <style>
            body {
      font-family: Arial, sans-serif;
      background-color: #f2f4f8;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .upload-container {
      background-color: #ffffff;
      padding: 40px;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      text-align: center;
      width: 400px;
    }

    .upload-container h2 {
      margin-bottom: 20px;
      color: #333333;
    }

    .file-input {
      margin-top: 20px;
    }

    input[type="file"] {
      padding: 10px;
      border: 2px dashed #007bff;
      border-radius: 8px;
      background-color: #f9f9f9;
      cursor: pointer;
      width: 100%;
    }

    input[type="file"]:hover {
      background-color: #eef5ff;
    }

    .submit-btn {
      margin-top: 30px;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
    }

    .submit-btn:hover {
      background-color: #0056b3;
    }
    </style>
</head>

<body>

    <div class="upload-container">
        <h2>Upload Excel File</h2>
        <form action="{{ route('process.excel') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="file-input">

                <input type="file" name="excel" accept=".xls, .xlsx" required>
            </div>


            <button type="submit" class="submit-btn">Generate Bubble Sheets</button>
        </form>

@if(session('error'))
    <div class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
@endif
    </div>

</body>

</html>
