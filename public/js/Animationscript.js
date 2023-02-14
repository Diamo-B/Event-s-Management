function animateCircle(element)
{
    let circProgress = element,
    progressValue = circProgress.querySelector('.progress-value');

    let progressStartValue = 0;
    let progressEndValue = circProgress.querySelector('.percentEnd').value;
    let speed = 20;

    let progress = setInterval(() => {
        
        progressValue.textContent = `${progressStartValue}%`;
        circProgress.style.background = `conic-gradient(rgb(99 102 241) ${progressStartValue * 3.6}deg, #ededed 0deg)`;
        if(progressStartValue == progressEndValue)
        {
            clearInterval(progress);
        }
        progressStartValue++;
    }, speed);
}

const divElements = document.querySelectorAll('.circular-progress')
divElements.forEach(element => {
    animateCircle(element);
}); 
