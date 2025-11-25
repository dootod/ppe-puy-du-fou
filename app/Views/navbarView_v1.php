<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: Arial, sans-serif;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 180px;
        background-color: #d1aa7d;
        border-top: 5px solid #000;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    footer li {
        list-style: none;
        color: #000;
        cursor: pointer;
        flex: 1;
        text-align: center;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    footer li a {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: inherit;
    }

    footer li .material-icons {
        font-size: 100px;
    }

    footer li.center {
        background-image: url('../../public/img/icon1.png');
        background-size: 250px 235px;
        background-repeat: no-repeat;
        background-position: center center;
        margin-bottom: 100; 
        height: 200px;
    }

    footer li.center .spacer {
        width: 250px;
        height: 250px;
        background: transparent;
    }
</style>

<footer>
    <li><a href="/"><i class="material-icons">home</i></a></li>
    <li><a href="/map"><i class="material-icons">place</i></a></li>
    <li class="center"><a href="/"><div class="spacer" aria-hidden="true"></div></a></li>
    <li><a href="/calendar"><i class="material-icons">calendar_month</i></a></li>
    <li><a href="/account"><i class="material-icons">account_circle</i></a></li>
</footer>