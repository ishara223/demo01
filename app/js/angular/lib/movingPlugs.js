var width = window.innerWidth;
var height = window.innerHeight;

var stage = new Konva.Stage({
    container: 'container',
    width: width,
    height: height
});

function drawTile(tileFile, dragFile, x, y, dropArea, side) {
    var imageObj = new Image();
    imageObj.onload = function() {

        var layer = new Konva.Layer();
        var tileImage = new Konva.Image({
            image: imageObj,
            x: x,
            y: y,
            width: 200,
            height: 137,
        });

        var draggableX = side === 'right' ? x + 250 : x - 150;
        var draggableY = y;
        var connectTo = {
            x: tileImage.position().x + tileImage.width() / 2,
            y: tileImage.position().y + tileImage.height() / 2
        }
        drawDraggable(layer, dragFile, draggableX, draggableY, dropArea, connectTo);
        layer.add(tileImage);
        stage.add(layer);
    };
    imageObj.src = tileFile;

}

function drawDraggable(layer, filename, x, y, dropAreas, connectTo) {

    var imageObj = new Image();
    imageObj.onload = function() {

        // create draggable image
        var dragImage = new Konva.Image({
            image: imageObj,
            x: x,
            y: y,
            width: 100,
            height: 100,
            draggable: true
        });

        // create a line
        var offset1X = -100;
        var offset1Y = 50;
        var offset2X = 5;
        var offset2Y = 25;
        var cableLine = new Konva.Line({
            points: [
                connectTo.x,
                connectTo.y,
                dragImage.position().x + dragImage.width() / 2,
                dragImage.position().y + dragImage.height() / 2
            ],
            stroke: 'yellow',
            strokeWidth: 5,
            lineCap: 'round',
            lineJoin: 'round'
        });

        dragImage.on('dragmove', function(e) {
            // updating line positions on drag move
            cableLine.points([
                connectTo.x,
                connectTo.y,
                dragImage.position().x + dragImage.width() / 2,
                dragImage.position().y + dragImage.height() / 2
            ]);

        });

        dragImage.on('dragstart', function() {
            // document.body.style.cursor = 'pointer';
        });
        dragImage.on('dragend', function() {
            // set to initial pos if wrong/ else dont do this
            var matchedArea = isWithinBounds(dropAreas, dragImage);

            if (!matchedArea) {
                dragImage.position({ x: x, y: y });
                cableLine.points([
                    connectTo.x,
                    connectTo.y,
                    dragImage.position().x + dragImage.width() / 2,
                    dragImage.position().y + dragImage.height() / 2
                ]);
                layer.draw();
                document.getElementById("demo2").innerHTML="නැවත උත්සහ කරන්න";
                document.getElementById('wrong').play();
                $('#demo2').removeClass("alert alert-success result-alert-box");
                 $('#demo2').addClass("alert alert-danger result-alert-box");
                 deductMarks();
                // DO ANGULAR UPDATES HERE IF INCORRECT
                return;
            } 

            // within bounds
            var pos = matchedArea.position();
            cableLine.points([
                connectTo.x,
                connectTo.y,
                pos.x + matchedArea.width() / 2,
                pos.y + matchedArea.height() / 2
            ]);
            dragImage.height(1);
            dragImage.width(1);
            layer.draw();

            //alert('Dropped to: ' + matchedArea.dropName);
            document.getElementById("demo2").innerHTML="සාර්ථකයි. නිවැරදිව පරිගණකයට උපකරණය සම්බන්ධ කරන ලදී.";
            document.getElementById('correct').play();
            $('#demo2').removeClass("alert alert-danger result-alert-box");
            $('#demo2').addClass("alert alert-success result-alert-box");
            addMarksActivityTwo();
        });

        layer.add(cableLine);
        layer.add(dragImage);
        stage.add(layer);

    };
    imageObj.src = filename;

}


function droppableSquare(x, y, width, height, dropName) {

    var layer = new Konva.Layer();
    
    var rect = new Konva.Rect({
        x: x,
        y: y,
        width: width,
        height: height,
        stroke: 'yellow',
        // fill: 'black',
        strokeWidth: 4
    });

    rect.on('mouseup', function() {
        alert();
    });
        
    layer.add(rect);
    stage.add(layer);

    rect.dropName = dropName;

    return rect;
}


function drawTile(tileFile, dragFile, x, y, dropArea, side) {
    var imageObj = new Image();
    imageObj.onload = function() {

        var layer = new Konva.Layer();
        
        // darth vader
        var tileImage = new Konva.Image({
            image: imageObj,
            x: x,
            y: y,
            width: 200,
            height: 137,
            // draggable: true
        });

        var draggableX = side === 'right' ? x + 250 : x - 150;
        var draggableY = y;
        var connectTo = {
            x: tileImage.position().x + tileImage.width() / 2,
            y: tileImage.position().y + tileImage.height() / 2
        }
        drawDraggable(layer, dragFile, draggableX, draggableY, dropArea, connectTo);

        layer.add(tileImage);
        stage.add(layer);

    };
    imageObj.src = tileFile;

}

function drawMainTile(tileFile,x,y) {

    var imageObj = new Image();
    imageObj.onload = function() {

        // for testing
        stage.on('click', function (e) {
            // console.log('clicked on', e.target);
            // console.log('usual click on ' + JSON.stringify(stage.getPointerPosition()));
        });
        
        var layer = new Konva.Layer();
        
        var tileImage = new Konva.Image({
            image: imageObj,
            x: x,
            y: y,
            width: 300,
            height: 600,
            opacity: 0.8
        });
        layer.add(tileImage);
        stage.add(layer);
    };
    imageObj.src = tileFile;
}

// check for rect intersection
function isWithinBounds(rectArr, rect2) {
    var match = null;
    rectArr.forEach(rect1 => {
        var r1 = {
            top: rect1.position().y,
            bottom: rect1.position().y + rect1.height(),
            left: rect1.position().x,
            right: rect1.position().x + rect1.width()
        };
        var r2 = {
            top: rect2.position().y,
            bottom: rect2.position().y + rect2.height(),
            left: rect2.position().x,
            right: rect2.position().x + rect2.width()
        };

        if(!(r2.left > r1.right || 
            r2.right < r1.left || 
            r2.top > r1.bottom ||
            r2.bottom < r1.top)) {
                match = rect1;
            }
    });
  
    return match;
}

var marks = 0;
var count = 0;

function initiateProgressBar(){
    document.getElementById('progressBar').style.width = marks+'%';
    document.getElementById('progressBar').innerHTML = marks+'%';
    document.getElementById('markDisplay').innerHTML = marks;
}

function addMarksActivityTwo(){
    count = count+1;
    if(count<=4){
        marks = marks+20;
    }
    else{
        marks = marks+10;
    }
    
    document.getElementById('progressBar').style.width = marks+'%';
    document.getElementById('progressBar').innerHTML = marks+'%';
    document.getElementById('markDisplay').innerHTML = marks;

    if(count == 6){
        angular.element(document.getElementById('episodeTwoCtrl')).scope().saveEpisodeTwoActivityTwoMarks(marks);
        angular.element(document.getElementById('episodeTwoCtrl')).scope().$apply();

        angular.element(document.getElementById('episodeTwoCtrl')).scope().showThirdVideo();
        angular.element(document.getElementById('episodeTwoCtrl')).scope().$apply();
    }
}

function deductMarks(){
    if(marks>0){
        marks= marks-5;
    }
    document.getElementById('progressBar').style.width = marks+'%';
    document.getElementById('progressBar').innerHTML = marks+'%';
    document.getElementById('markDisplay').innerHTML = marks;
}

function fitStageIntoParentContainer() {
    var container = document.getElementById('container');

    // now we need to fit stage into parent
    var containerWidth = container.offsetWidth;
    // to do this we need to scale the stage
    var scale = containerWidth / 1920;


    stage.width(1920 * scale);
    stage.height(height * scale);
    stage.scale({ x: scale, y: scale });
    stage.draw();
}

fitStageIntoParentContainer();
// adapt the stage on any window resize
window.addEventListener('resize', fitStageIntoParentContainer);

drawMainTile('/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/Connecting_Devices_Back.png',700,100);

// create droppable regions
var mic = droppableSquare(868, 240, 16, 13, 'mic');
var network = droppableSquare(873, 271, 31, 28, 'network');
var hdmi = droppableSquare(936, 390, 21, 28, 'hdmi');
var power = droppableSquare(770, 558, 65, 73, 'power');
var vga = droppableSquare(925, 434, 26, 55, 'vga');
var usb = droppableSquare(914, 273, 37, 32, 'usb');
var usb2 = droppableSquare(914, 350, 38, 32, 'usb');

// create components
drawTile('/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/mic_2.png', '/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/audiojack.png', 200, 100, [mic], 'right');
drawTile('/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/router.png', '/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/network.png', 200, 300, [network], 'right');
drawTile('/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/ups2.png', '/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/power.png', 200, 500, [power], 'right');

drawTile('/e-lankapura/app/src/img/episodeTwo/activities/keyboard.png','/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/usb.png', 1200, 100, [usb, usb2], 'left');
drawTile('/e-lankapura/app/src/img/episodeTwo/activities/output/monitor.png','/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/hdmi.png', 1200, 300, [hdmi], 'left');
drawTile('/e-lankapura/app/src/img/episodeTwo/activities/output/monitor.png','/e-lankapura/app/src/img/episodeTwo/activities/activityTwo/vga.png', 1200, 500, [vga], 'left');
