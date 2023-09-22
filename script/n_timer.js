const hoursElement = document.getElementById('hours');
const minutesElement = document.getElementById('minutes');
const secondsElement = document.getElementById('seconds');
const baseInput = document.getElementById('base-input');
const hoursInput = document.getElementById('hours-input');
const minutesInput = document.getElementById('minutes-input');
const secondsInput = document.getElementById('seconds-input');
const startButton = document.getElementById('start-button');
const stopButton = document.getElementById('stop-button');
const resumeButton = document.getElementById('resume-button');
const resetButton = document.getElementById('reset-button');
const alarmStopButton = document.getElementById('alarm-stop-button');
let intervalId;
let alarmIntervalId;
let isAlarmPlaying = false;
let isPaused = false;
let startTime;
let pausedTime;

startButton.addEventListener('click', startTimer);
stopButton.addEventListener('click', stopTimer);
resumeButton.addEventListener('click', resumeTimer);
resetButton.addEventListener('click', resetTimer);
alarmStopButton.addEventListener('click', stopAlarm);

function startTimer() {
  if (isPaused) {
    resumeTimer();
    return;
  }

  const base = parseInt(baseInput.value);
  let hours = parseInt(hoursInput.value);
  let minutes = parseInt(minutesInput.value);
  let seconds = parseInt(secondsInput.value);

  let totalTime = hours * 3600 + minutes * 60 + seconds;
  let remainingTime = totalTime;

  clearInterval(intervalId);
  intervalId = setInterval(() => {
    if (remainingTime <= 0) {
      clearInterval(intervalId);
      hoursElement.textContent = '00';
      minutesElement.textContent = '00';
      secondsElement.textContent = '00';
      handleCountdownFinished();
      return;
    }

    let remainingHours = Math.floor(remainingTime / 3600);
    let remainingMinutes = Math.floor((remainingTime % 3600) / 60);
    let remainingSeconds = remainingTime % 60;

    hoursElement.textContent = formatTime(remainingHours, parseInt(baseInput.value));
    minutesElement.textContent = formatTime(remainingMinutes, parseInt(baseInput.value));
    secondsElement.textContent = formatTime(remainingSeconds, parseInt(baseInput.value));

    remainingTime--;
  }, 1000);
}

function stopTimer() {
  clearInterval(intervalId);
  isPaused = true;
  pausedTime = {
    hours: parseInt(hoursElement.textContent),
    minutes: parseInt(minutesElement.textContent),
    seconds: parseInt(secondsElement.textContent)
  };
  resumeButton.style.display = 'inline-block';
}

function resumeTimer() {
  isPaused = false;
  let remainingTime = pausedTime.hours * 3600 + pausedTime.minutes * 60 + pausedTime.seconds;

  clearInterval(intervalId);
  intervalId = setInterval(() => {
    if (remainingTime <= 0) {
      clearInterval(intervalId);
      hoursElement.textContent = '00';
      minutesElement.textContent = '00';
      secondsElement.textContent = '00';
      handleCountdownFinished();
      return;
    }

    let remainingHours = Math.floor(remainingTime / 3600);
    let remainingMinutes = Math.floor((remainingTime % 3600) / 60);
    let remainingSeconds = remainingTime % 60;

    hoursElement.textContent = formatTime(remainingHours, parseInt(baseInput.value));
    minutesElement.textContent = formatTime(remainingMinutes, parseInt(baseInput.value));
    secondsElement.textContent = formatTime(remainingSeconds, parseInt(baseInput.value));

    remainingTime--;
  }, 1000);

  resumeButton.style.display = 'none';
}

function resetTimer() {
  clearInterval(intervalId);
  hoursElement.textContent = '00';
  minutesElement.textContent = '00';
  secondsElement.textContent = '00';
  stopAlarm();
  isPaused = false;
  resumeButton.style.display = 'none';
}

function formatTime(time, base) {
  let formattedTime = time.toString(base);
  return formattedTime.padStart(2, '0').replace(/[０-９]/g, function (s) {
    return String.fromCharCode(s.charCodeAt(0) - 0xfee0);
  });
}

function handleCountdownFinished() {
  alert('カウントダウン終了!');
  showAlarmStopButton();
  playAlarm();
}

function showAlarmStopButton() {
  alarmStopButton.style.display = 'inline-block';
}

function playAlarm() {
  if (!isAlarmPlaying) {
    isAlarmPlaying = true;
    alarmIntervalId = setInterval(() => {
      // アラーム音の再生処理を実装する（ここでは省略）
      console.log('アラーム音を再生中...');
    }, 1000);
  }
}

function stopAlarm() {
  if (isAlarmPlaying) {
    isAlarmPlaying = false;
    clearInterval(alarmIntervalId);
    // アラーム音の停止処理を実装する（ここでは省略）
    console.log('アラーム音を停止しました。');
    alarmStopButton.style.display = 'none';
  }
}
