function saveMemo() {
    var memoText = document.getElementById("memoInput").value;
    
    var blob = new Blob([memoText], {type: "text/plain"});
    var url = URL.createObjectURL(blob);
    
    var a = document.createElement("a");
    a.href = url;
    a.download = "memo.txt";
    a.click();
}

// memo.js

function loadMemo(selectElement) {
    var selectedTitle = selectElement.value;

    // Ajaxリクエストを使用してサーバーからデータを取得
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "load_memo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var memoText = xhr.responseText;

            // 取得したメモデータを表示
            document.getElementById("memoTitle").value = selectedTitle; // タイトルは選択されたタイトル
            document.getElementById("memoInput").value = memoText;
            countCharacters(document.getElementById("memoInput"));
        }
    };

    // 選択されたタイトルをサーバーに送信
    xhr.send("selectedTitle=" + encodeURIComponent(selectedTitle));
}


function saveToDatabase() {
    var memoTitle = document.getElementById("memoTitle").value;
    var memoText = document.getElementById("memoInput").value;

    // Ajaxリクエストを使用してサーバーにデータを送信
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_to_db.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    };

    // メモのタイトルが空でない場合、memoTitleパラメータを送信する
    var data = "memoText=" + encodeURIComponent(memoText);
    if (memoTitle.trim() !== "") {
        data += "&memoTitle=" + encodeURIComponent(memoTitle);
    }

    xhr.send(data);
}

function countCharacters(textarea) {
    const characterCountElement = document.getElementById("characterCount");
    const characterCount = textarea.value.length;
    characterCountElement.textContent = characterCount + "文字";
}

let recognition;
let memoInput = document.getElementById('memoInput');

function startRecognition() {
    recognition = new webkitSpeechRecognition();
    recognition.lang = 'ja-JP';
    recognition.continuous = true;
    recognition.interimResults = true;

    recognition.onresult = function(event) {
        let result = '';
        for (let i = event.resultIndex; i < event.results.length; i++) {
            if (event.results[i].isFinal) {
                result += event.results[i][0].transcript;
            }
        }
        memoInput.value += result;
    };

    recognition.start();
}

function resetRecognition() {
    if (recognition) {
        recognition.stop();
        recognition = null;
    }
}
