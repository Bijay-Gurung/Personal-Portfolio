let text = document.getElementById("changeText");
let textList = ["Full-Stack Web Developer","Student","Python Developer","3D-Model Designer","Graphic-Designer","Story-writer","Video Grapher","Video Editor","Photo Grapher","Content Creator","Photo Editor"];
let i = 0;

function ChangingText() {
    text.textContent = textList[i];
    i = (i + 1) % textList.length;
}

ChangingText();
setInterval(ChangingText, 2000);

function myResume(){
    window.open("White Simple Student Cv Resume.pdf");
}