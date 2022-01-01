<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+HK:wght@100;300;400;500&family=Noto+Sans+TC:wght@500;700;900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Noto Sans HK', sans-serif;
            font-family: 'Noto Sans TC', sans-serif;
        }

        .container-wrap {
            background: linear-gradient(to right, #021943 0%, #023f74 100%);
            height: 100vh;  /*為了讓背景色顯示，預設高度100vh。*/
            width: 80%;
            position: absolute;
            right: 0;
        }

        img {
            width: 100%;
        }

        #navbar {
            position: fixed;
            left: 0;
            top: 0;
        }

        #navbar a {
            color: #00002D;
        }

        .nav-pills .nav-link.active {
            background-color: #05f2f2;
        }

        #navbar hr {
            background-color: #05f2f2;
            height: 3px;
            border: none;
        }

        .logo {
            width: 40px;
            border-radius: 50%;
            overflow: hidden;
        }

        .userPic {
            width: 32px;
            height: 32px;
        }

        .dropdown-menu {
            background-color: #05f2f2;
        }
    </style>
</head>

<body>
<div class="container-wrap">
