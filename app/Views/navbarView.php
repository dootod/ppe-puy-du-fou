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
    }

    footer li .material-icons {
        font-size: 100px;
    }

    footer li .custom-icon {
        width: 250px;
        height: 250px;
        object-fit: contain;
        margin-bottom: 100px;
    }
</style>

<footer>
    <li><i class="material-icons">home</i></li>
    <li><i class="material-icons">place</i></li>
    <li><img src="../../public/img/icon1.png" class="custom-icon" alt="icone1"></li>
    <li><i class="material-icons">calendar_month</i></li>
    <li><i class="material-icons">account_circle</i></li>
</footer>