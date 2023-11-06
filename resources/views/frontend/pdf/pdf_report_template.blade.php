<!-- You can customize the layout of the PDF here -->
<!DOCTYPE html>
<html>
<head>
    <title>PDF Template</title>
    <style>
        /* Avoid page breaks inside elements with class "no-page-break" */
        .no-page-break {
            page-break-inside: avoid;
        }
    </style>
</head>
<body>
    <div>
        <img src="{{ $imagePath }}" alt="Image" style="width: 100%;">
    </div>
</body>
</html>
