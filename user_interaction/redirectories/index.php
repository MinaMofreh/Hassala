<?php ?>

<script type="text/javascript" src="main.js"></script>
<script type="text/javascript" src="llqrcode.js"></script>

<div style="display:none" id="result"></div>
<div class="selector" id="webcamimg" onclick="setwebcam()" align="left" ></div>
<div class="selector" id="qrimg" onclick="setimg()" align="right" ></div>
<div class="test">
    <hr>
</div>
<center id="mainbody"><div id="outdiv"></div></center>
<h2>Please, allow Camera request from browser</h2>
<canvas id="qr-canvas" width="800" height="600"></canvas>

<img src="qr.png" alt="qrcode Example"/>
<script type="text/javascript">load();</script>
<script src="./jquery-1.11.2.min.js"></script>

<style>
    hr{
        width:293px;
        background:rgba(255,20,20,0.9);
        height: 7px;
        font-weight: bold;
    }
    .test {
        animation: MoveUpDown 2.5s linear infinite;
        position: absolute;
        margin-left: 455px;
        margin-bottom: 400px;
        left: 0;
        bottom: 0;
    }

    @keyframes MoveUpDown {
        0% {
            bottom: 0;
        }
        50% {
            bottom: 250px;
        }
        100% {
            bottom: 0;
        }
    }
    body{
        background-color:#4ad6c3;
        background-image: url(../images/f.png);
    }
    h2{
        padding-top: 120px;
        padding-left: 350px;
        background-color: grey;
    }
    img{
        padding-left: 500px;
        padding-top: 50px;	
    }
    #qr-canvas{
        display:none;
    }

    #outdiv{
        margin-left: 0px auto; 
        width:190px;
        height:190px;
        padding-right: 180px;
    }

    #v{
        width:290px;
        height:290px;
        border: 2px solid;
        border-radius: 25px;
        background-color: black;
    }

    @media screen and (max-width: 480px){

        #outdiv{
            width:190px;
            height:190px;
        }

        #v{
            width:190px;
            height:190px;
        }

        @media screen and (max-device-width: 480px) 
        and (orientation:portrait){

            #outdiv{
                width:270px;
                height:270px;

            }

            #v{
                width:270px;
                height:270px;
            }

        }

    }

</style>