<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>n進数のカウントダウンタイマー</title>
  <link rel="stylesheet" type="text/css" href="css/n_timer.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
  <header>
    <h1>n進数のカウントダウンタイマー</h1>
  </header>
  <div id="navArea">
  <?php include './component/nav.php'; ?>
    <div class="toggle-btn">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <div id="mask"></div>
  </div>
  <div id="content">
    <div id="timer">
      <span class="timer-element" id="hours">00</span>：
      <span class="timer-element" id="minutes">00</span>：
      <span class="timer-element" id="seconds">00</span>
    </div>
    <div class="input-container">
      <div class="label-input-container">
        <input type="number" id="base-input" min="2" max="16" value="10" class="input-element">
        <label for="base-input">進数　　</label>
      </div>
      <div class="label-input-container">
        <input type="number" id="hours-input" min="0" value="0" class="input-element">
        <label for="hours-input">時　　</label>
      </div>
      <div class="label-input-container">
        <input type="number" id="minutes-input" min="0" value="0" class="input-element">
        <label for="minutes-input">分　　</label>
      </div>
      <div class="label-input-container">
        <input type="number" id="seconds-input" min="0" value="0" class="input-element">
        <label for="seconds-input">秒　　</label>
      </div>
    </div>
    <div class="button-container">
      <button id="start-button" class="button-element">スタート</button>
      <button id="stop-button" class="button-element">ストップ</button>
      <button id="resume-button" class="button-element" style="display: none;">再開</button>
      <button id="reset-button" class="button-element">リセット</button>
    </div>
    <button id="alarm-stop-button" class="button-element" style="display: none;">アラーム停止</button>
  </div>
  <footer>
    <p>&copy; 2023 n進数のカウントダウンタイマー</p>
  </footer>
  <script src="script/n_timer.js"></script>
  <script src="script/script.js"></script>
</body>
</html>
