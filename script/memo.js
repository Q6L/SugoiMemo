function saveMemo() {
    var memoText = document.getElementById("memoInput").value;
    
    var blob = new Blob([memoText], {type: "text/plain"});
    var url = URL.createObjectURL(blob);
    
    var a = document.createElement("a");
    a.href = url;
    a.download = "memo.txt";
    a.click();
}

function saveToDatabase() {
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
    xhr.send("memoText=" + encodeURIComponent(memoText));
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
