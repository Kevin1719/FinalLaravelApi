<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

    
    <form action="{{route('import')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12"></div>
            <div class="col-md-2"></div>
                <div class="col-md-8"><div>
                    <label for="formFileLg" class="form-label">Large file input example</label>
                    <input class="form-control form-control-lg" id="formFileLg" name="fichier" type="file">
                </div>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Importer">
    </form>

</body>
</html>