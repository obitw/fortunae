<body onload="sonActivationBackground()">
<div id="overlay"></div>

<div class="containerJeu">
    <div class="containerDonnée">
        <div class="stats border-to-red">
            <div class="itemEcrit">
                Credit:
            </div>
            <div class="item">
                <p id="credit"></p>
            </div>
            <div class="item">
                F
            </div>
        </div>
        <div class="stats border-to-red">
            <div class="itemEcrit">
            Mise:
            </div>
            <div class="item">
                <p id="mise"></p>
            </div>
            <div class="item">
                F
            </div>
        </div>
        <div class="stats gainDiv border-to-red">
            <div class="itemEcrit">
                Gain:
            </div>
            <div class="item">
                <p id="gain"></p>
            </div>
            <div class="item">
                F
            </div>
        </div>
    </div>

    <div id="winMessage">WIN</div>


    <div class="machine">
        <div class="colonne slot1 border-to-red">
            <div class="emplacement">
                <div id="symbole1">
                </div>
            </div>
            <div class="emplacement">
                <div id="symbole2">
                </div>
            </div>
            <div class="emplacement">
                <div id="symbole3">
                </div>
            </div>
        </div>
        <div class="colonne slot2 border-to-red">
            <div class="emplacement">
                <div id="symbole4">
                </div>
            </div>
            <div class="emplacement">
                <div id="symbole5">
                </div>
            </div>
            <div class="emplacement">
                <div id="symbole6">
                </div>
            </div>
        </div>
        <div class="colonne slot3 border-to-red">
            <div class="emplacement">
                <div id="symbole7">
                </div>
            </div>
            <div class="emplacement">
                <div id="symbole8">
                </div>
            </div>
            <div class="emplacement">
                <div id="symbole9">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="containerBouton">
    <div class="containerBoutonMise">
        <div class="containerMise">
            <div class="containerMisePlus">
                <div class="boutonMise">
                    <button id="miserMin">Min</button>
                </div>
                <div class="boutonMise">
                    <button id="miserDiviserDix">÷10</button>
                </div>
                <div class="boutonMise">
                    <button id="miserDiviserDeux">÷2</button>
                </div>
                <div class="boutonMise">
                    <button id="miserMoinsMille">-1000</button>
                </div>
                <div class="boutonMise">
                    <button id="miserMoinsCent">-100</button>
                </div>
            </div>
            <div class="miser">
                Miser
            </div>
            <div class="containerMiseMoins">
                <div class="boutonMise">
                    <button id="miserPlusCent">+100</button>
                </div>
                <div class="boutonMise">
                    <button id="miserPlusMille">+1000</button>
                </div>
                <div class="boutonMise">
                    <button id="miserFoisDeux">x2</button>
                </div>
                <div class="boutonMise">
                    <button id="miserFoisDix">x10</button>
                </div>
                <div class="boutonMise">
                    <button id="miserMax">Max</button>
                </div>
            </div>
        </div>
        <div class="boutonJouer">
            <button id="startButton">Jouer</button>
        </div>
    </div>
    <div class="containerParametre">
        <div class="information">
                <a onclick="open('ControleurFrontal.php?action=afficherRegles&controleur=machineasous', 'Popup', 'height=700,width=500');" >
                    <img class="info" src="../ressource/img/logoInfo.png" alt="Info">
                </a>
        </div>
        <div class="sonBackground">
            <image id="sonBackgroundButton" type="button" src="../ressource/img/du-son.png" height="50VH"></image>
        </div>
    </div>
</div>



<div class="espace">

</div>
<script src="../ressource/js/app.js?v=<?php echo time(); ?>"> //Le echo time sert à ce que le fichier ne reste pas en cache
</script>
</body>
