window.onload = function () {
	var angle = 0;
	var oyster = document.getElementById("oyster_kun");
	var rotateCount = 0;
	var intervalRotateOyster;

	if(oyster != null) {
		oyster.addEventListener('mouseover', () => {
			if(rotateCount < 1) { 
        			intervalRotateOyster = setInterval(rotateOyster, 10);
			}
		}, false);
	}

	const rotateOyster = () => {
        	angle += 3;
        	oyster.style.transform = "rotateY(" + angle + "deg)";
        	rotateCount += 1;
        	if (rotateCount >= 240) {
                	clearInterval(intervalRotateOyster);
                	rotateCount = 0;
        	}
	};
};
