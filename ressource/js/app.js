const tabUrlImage = [
    "../ressource/img/machine/orange.png",
    "../ressource/img/machine/banane.png",
    "../ressource/img/machine/pasteque.png",
    "../ressource/img/machine/raisin.png",
    "../ressource/img/machine/citron.png",
    "../ressource/img/machine/cerise.png",
    "../ressource/img/machine/jackpot.png"];



function createNewImage(src) {
    const img = document.createElement("img");
    img.src = src;
    return img;
}
function randomize(tab) {
    let i, j, tmp;
    for (i = tab.length - 1; i > 0; i--) {
        j = Math.floor(Math.random() * (i + 1));
        tmp = tab[i];
        tab[i] = tab[j];
        tab[j] = tmp;
    }
    return tab;
}
function randint(min, max) {
    return Math.floor(Math.random() * (max - min + 1) ) + min;
}

function chercherSymboleGagnant(resultat){
    let listeSymboleGagnant = new Set();
    if(resultat[0][0] === resultat[0][1] && resultat[0][2] === resultat[0][0]){
        listeSymboleGagnant.add(document.getElementById("symbole1"));
        listeSymboleGagnant.add(document.getElementById("symbole4"));
        listeSymboleGagnant.add(document.getElementById("symbole7"));
    }
    if(resultat[1][0] === resultat[1][1] && resultat[1][2] === resultat[1][0]){
        listeSymboleGagnant.add(document.getElementById("symbole2"));
        listeSymboleGagnant.add(document.getElementById("symbole5"));
        listeSymboleGagnant.add(document.getElementById("symbole8"));
    }
    if(resultat[2][0] === resultat[2][1] && resultat[2][2] === resultat[2][0]){
        listeSymboleGagnant.add(document.getElementById("symbole3"));
        listeSymboleGagnant.add(document.getElementById("symbole6"));
        listeSymboleGagnant.add(document.getElementById("symbole9"));
    }
    if(resultat[0][0] === resultat[1][1] && resultat[2][2] === resultat[0][0]){
        listeSymboleGagnant.add(document.getElementById("symbole1"));
        listeSymboleGagnant.add(document.getElementById("symbole5"));
        listeSymboleGagnant.add(document.getElementById("symbole9"));
    }
    if(resultat[0][2] === resultat[1][1] && resultat[2][0] === resultat[0][2]){
        listeSymboleGagnant.add(document.getElementById("symbole3"));
        listeSymboleGagnant.add(document.getElementById("symbole5"));
        listeSymboleGagnant.add(document.getElementById("symbole7"));
    }

    return listeSymboleGagnant;
}


const slot1 = document.querySelector(".slot1")
const slot2 = document.querySelector(".slot2")
const slot3 = document.querySelector(".slot3")
function setupRoulette(){
    for (let i = 1; i < 4; i++) {
        slot1.querySelector("#symbole"+i.toString()).appendChild(createNewImage(tabUrlImage[randint(0, tabUrlImage.length - 1)]));
        slot2.querySelector("#symbole"+(i+3).toString()).appendChild(createNewImage(tabUrlImage[randint(0, tabUrlImage.length - 1)]));
        slot3.querySelector("#symbole"+(i+6).toString()).appendChild(createNewImage(tabUrlImage[randint(0, tabUrlImage.length - 1)]));
    }

}
let enjeu = false
function animationRoulette(resultat, newGain, newCredit){
    const toutLesSymboles = []
    enleverSon();
    if (boolSon){
        sonRoulementAlea(true);
    }
    for (let i = 1; i < 10; i++) {
        let symbole = document.getElementById("symbole"+i.toString());
        symbole.classList.remove('symbole-gagnant');
        toutLesSymboles.push(symbole);
    }

    const gainElement = document.getElementsByClassName("gainDiv");
    Array.from(gainElement).forEach(function(element) {
        Array.from(element.children).forEach(function (child) {
            child.classList.remove('text-clignotant');
        });
    });

    const symbolesGagnant = chercherSymboleGagnant(resultat);

    let gainCache = document.getElementById("gain")
    enjeu = true;
    let tabImages = [slot1.querySelectorAll("img"), slot2.querySelectorAll("img"), slot3.querySelectorAll("img")];
    let tabIdIntervalId = [[], [], []];

    let stopDelays = [1500, 3000, 4500]; // en millisecondes

    tabImages.forEach((tab, indexColonne) => {
        let intervalId = setInterval(() => {
            for (let i = tab.length - 1; i > 0; i--) {
                tab[i].src = tab[i - 1].src;
            }
            tab[0].src = tabUrlImage[randint(0, tabUrlImage.length - 1)];
        }, 140);

        setTimeout(() => {
            clearInterval(intervalId);
            tab[0].src = tabUrlImage[resultat[0][indexColonne] - 1]; // Fixer le symbole gagnant en haut
            tab[1].src = tabUrlImage[resultat[1][indexColonne] - 1]; // Fixer le symbole gagnant au milieu
            tab[2].src = tabUrlImage[resultat[2][indexColonne] - 1]; // Fixer le symbole gagnant en bas
        }, stopDelays[indexColonne]);

    });
    if (boolSon){
        setTimeout(() => {
            sonRoulementAlea(false);
        }, stopDelays[2])
    }
    setTimeout(()=>{
        enjeu = false;
        document.getElementById("gain").innerHTML = newGain;
        majText(credit, mise, gain);
        gain = parseInt(newGain);
        credit = parseInt(newCredit);


        if(newGain > 0){ //Le joueur a gagné
            setTimeout(() =>{gainIcrementeClignotant(newGain);}, 1000);
            showWinMessage();
            if (boolSon){
                sonActivation(true, sonJackpot);
                sonActivation(true, sonWin);
                setTimeout(() =>{
                    sonActivation(false, sonWin);
                }, 9500)
            }
            for (const symbole of symbolesGagnant) {
                symbole.classList.add('symbole-gagnant');
            }

        }
        else{
            if (boolSon){
                sonFailAlea(true);
            }
            shakeScreen();
            redBorder();
        }
    },4550);
}
function miserMoins(valeur){
    miser(false,valeur);
}

function miserPlus(valeur){
    miser(true,valeur);
}

function miser(plus,valeur){
    if (boolSon){
        sonActivation(true, sonMise);
    }
    let donneesMAJ = {"mise": mise,"valeur": valeur};
    let typeMise = "";
    plus ? typeMise = "miserPlus": typeMise = "miserMoins";
    fetch("ControleurFrontal.php?action="+typeMise+"&controleur=machineasous", {
        method: "POST",
        body: JSON.stringify(donneesMAJ),
        headers: {
            'Content-Type': 'application/json'
        }
    })
        .then(response => response.json())
        .then(data =>{
            mise = parseInt(data.mise);
            majText(credit, mise, gain);
        })
        .then(error => (error === undefined) ? console.log(typeMise):console.log("Erreur "+typeMise + " : "+error))
}

function majText(credit, mise, gain){
    document.getElementById("credit").innerHTML = credit.toString();
    document.getElementById("mise").innerHTML = mise.toString();
    document.getElementById("gain").innerHTML = gain.toString();
}


function jouerRoulette(){
    if (!enjeu) {
        fetch("ControleurFrontal.php?action=lancer&controleur=machineasous", {
            method: "POST",
            body: null
        })
            .then(response => response.json())
            .then(data => {
                if (data["erreur"] === 0) {
                    credit -= mise;
                    gain = 0;
                    majText(credit, mise, gain);
                    animationRoulette(data["resultat"], data["gain"], data["credit"]);
                } else if (data["erreur"] === 1) {
                    alert("Vous n'avez plus assez de crédit");
                } else if (data["erreur"] === 2) {
                    alert("Vous ne pouvez pas miser 0 crédit");
                }
            })
            .then(error => (error === undefined) ? console.log("Jouer") : console.log("Erreur jeu : " + error))
    }
}

function recupCreditMiseGain(){
    fetch("ControleurFrontal.php?action=sendData&controleur=machineasous", {
        method: "POST",
        body: null
    })
        .then(response => response.json())
        .then(data => {
            credit = parseInt(data["credit"]);
            mise = parseInt(data["mise"]);
            gain = parseInt(data["gain"]);
            majText(credit, mise, gain);
        })
        .then(error => (error === undefined) ? console.log("Recupération des données") : console.log("Erreur recup : " + error))
}

function shakeScreen() {
    const body = document.querySelector('body');
    body.classList.add('shake');
    setTimeout(function() {
        body.classList.remove('shake');
    }, 400);
}

function gainIcrementeClignotant(reach){
    const gainHTML = document.getElementById("gain");
    let gainElements = document.getElementsByClassName("gainDiv");
    Array.from(gainElements).forEach(function(element) {
        Array.from(element.children).forEach(function (child) {
            child.classList.add('text-clignotant');
        });
    });
    let gainCurrent = parseInt(gainHTML.innerHTML);
    let interval = 1;
    let increment = Math.max(Math.round(reach * 0.01), 1);
    if(gainCurrent < reach){
        let intervalId = setInterval(function updateCounter() {
            gainCurrent += increment;
            if(gainCurrent >= reach) {
                clearInterval(intervalId);
                gainCurrent = reach;
                gainHTML.innerHTML = gainCurrent.toString();
            } else {
                gainHTML.innerHTML = gainCurrent.toString();
                if (gainCurrent >= reach * 0.75){
                    increment = Math.max(Math.floor(reach * 0.005), 1);
                    interval += 2;
                    clearInterval(intervalId);
                    intervalId = setInterval(updateCounter, interval);
                }
            }
        }, interval);
    }
}


function redBorder(){
    const colonnes = document.getElementsByClassName("border-to-red");

    Array.from(colonnes).forEach(function(element) {
        element.classList.add('border-red');
    });
    setTimeout(function() {
        Array.from(colonnes).forEach(function(element) {
            element.classList.remove('border-red');
        });
    }, 1000);
}

let sonRoulement = new Audio("../ressource/audio/Roulement.mp3");
let sonMise = new Audio("../ressource/audio/Mise.mp3");
let sonJackpot = new Audio("../ressource/audio/Jackpot.mp3");
let sonWin = new Audio("../ressource/audio/Win.mp3");
sonWin.loop = true;
let sonFail = new Audio("../ressource/audio/Fail1.mp3");
let sonBackground = new Audio("../ressource/audio/Background1.mp3");
sonJackpot.volume = 0.60;
sonBackground.volume = 0.35;
sonBackground.loop = true;
let boolSon = true;
function sonActivation(active, audio){
    if (active){
        audio.play();
    }
    else {
        audio.pause()
        audio.currentTime = 0;
    }
}

function sonActivationBackground(){
    let img = document.getElementById("sonBackgroundButton");
    if (!sonBackground.paused){
        boolSon = false;
        img.src = '../ressource/img/pas-de-son.png';
        sonBackground.pause();
        enleverSon();

    }
    else{
        boolSon = true;
        img.src = '../ressource/img/du-son.png';
        sonActivation(true, sonBackground);
    }
}

function enleverSon(){
    sonActivation(false,sonFail);
    sonActivation(false,sonWin);
    sonActivation(false, sonJackpot);
    sonActivation(false, sonMise);
    sonActivation(false, sonRoulement);
}


function sonRoulementAlea(active){
    if(!sonRoulement.paused){
        sonRoulement.pause();
        sonRoulement.currentTime = 0;
    }
    else {
        const nbr = Math.floor(Math.random() * 2);
        if (nbr === 0){
            sonRoulement = new Audio("../ressource/audio/Roulement.mp3");
        }
        else{
            sonRoulement = new Audio("../ressource/audio/Roulement2.mp3");
        }
        sonActivation(active, sonRoulement);
    }
}

function sonFailAlea(active){
    if(!sonFail.paused){
        sonActivation(false, sonFail);
    }
    else {
        const nbr = Math.floor(Math.random() * 4);
        if (nbr === 0){
            sonFail = new Audio("../ressource/audio/Fail1.mp3");
        }
        else if (nbr === 1){
            sonFail = new Audio("../ressource/audio/Fail2.mp3");
        }
        else if (nbr === 2){
            sonFail = new Audio("../ressource/audio/Fail3.mp3");
        }
        else {
            sonFail = new Audio("../ressource/audio/Fail4.mp3");
        }
        sonActivation(active, sonFail);
    }
}
function showWinMessage() {
    let winMessage = document.getElementById('winMessage');
    let overlay = document.getElementById('overlay');

    winMessage.classList.add('show-winMessage');
    overlay.classList.add('show-overlay');

    setTimeout(function() {
        winMessage.classList.remove('show-winMessage');
        overlay.classList.remove('show-overlay');
    }, 1500);
}


document.getElementById("sonBackgroundButton").addEventListener("click", sonActivationBackground);

let mise = 0;
let gain = 0;
let credit = 0;
recupCreditMiseGain();
setupRoulette();

document.getElementById("startButton").addEventListener("click", jouerRoulette);
//miser plus
document.getElementById("miserPlusCent").addEventListener("click", () => { miserPlus(100);});
document.getElementById("miserPlusMille").addEventListener("click", () => { miserPlus(1000);});
document.getElementById("miserFoisDeux").addEventListener("click", () => { miserPlus(2);});
document.getElementById("miserFoisDix").addEventListener("click", () => { miserPlus(10);});
document.getElementById("miserMax").addEventListener("click", () => { miserPlus(0);});

//miser moins
document.getElementById("miserMoinsCent").addEventListener("click", () => { miserMoins(100);});
document.getElementById("miserMoinsMille").addEventListener("click", () => { miserMoins(1000);});
document.getElementById("miserDiviserDeux").addEventListener("click", () => { miserMoins(2);});
document.getElementById("miserDiviserDix").addEventListener("click", () => { miserMoins(10);});
document.getElementById("miserMin").addEventListener("click", () => { miserMoins(0);});



