function saveMemo() {
    var memoText = document.getElementById("memoInput").value;
    
    var blob = new Blob([memoText], {type: "text/plain"});
    var url = URL.createObjectURL(blob);
    
    var a = document.createElement("a");
    a.href = url;
    a.download = "memo.txt";
    a.click();
}

function loadMemo(selectElement) {
    var selectedTitle = selectElement.value;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "load_memo.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            var memoText = xhr.responseText;

            document.getElementById("memoTitle").value = selectedTitle;
            document.getElementById("memoInput").value = memoText;
            countCharacters(document.getElementById("memoInput"));
        }
    };

    xhr.send("selectedTitle=" + encodeURIComponent(selectedTitle));
}


function saveToDatabase() {
    var memoTitle = document.getElementById("memoTitle").value;
    var memoText = document.getElementById("memoInput").value;

    if (memoTitle.trim() === "") {
        alert("タイトルを入力してください");
        return;
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_to_db.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                console.log(xhr.responseText);
                if (xhr.responseText === "TitleDuplicateError") {
                    alert("エラー: 同じタイトルのメモが既に存在します");
                } else {
                    alert("メモが保存されました");
                }
            } else {
                alert("通信エラーが発生しました");
            }
        }
    };

    var data = "memoText=" + encodeURIComponent(memoText) + "&memoTitle=" + encodeURIComponent(memoTitle);
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

function deleteMemo() {
    var selectedTitle = document.getElementById("memoTitleSelect").value;

    if (selectedTitle !== "") {
        var confirmDelete = confirm("選択されたメモを削除します。よろしいですか？");

        if (confirmDelete) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_memo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                }
            };

            xhr.send("memoTitle=" + selectedTitle);
        }
    } else {
        alert("メモを選択してください");
    }
}