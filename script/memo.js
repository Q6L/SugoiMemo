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

    // タイトルが空の場合、メッセージを表示して終了
    if (memoTitle.trim() === "") {
        alert("タイトルを入力してください");
        return;
    }

    // Ajaxリクエストを使用してサーバーにデータを送信
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "save_to_db.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4) {
            if (xhr.status == 200) {
                // レスポンスが成功の場合
                console.log(xhr.responseText);
                if (xhr.responseText === "TitleDuplicateError") {
                    // タイトルが重複する場合のエラー処理
                    alert("エラー: 同じタイトルのメモが既に存在します");
                } else {
                    // タイトルが重複しない場合の処理
                    alert("メモが保存されました");
                }
            } else {
                // 通信エラーの場合のエラー処理
                alert("通信エラーが発生しました");
            }
        }
    };

    // メモのタイトルと本文を送信
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
        // 確認ダイアログを表示
        var confirmDelete = confirm("選択されたメモを削除します。よろしいですか？");

        if (confirmDelete) {
            // Ajaxリクエストを作成
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "delete_memo.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // レスポンスの処理
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // 削除が成功した場合の処理
                    alert(xhr.responseText); // レスポンスを表示するか、他の処理を追加することができます
                }
            };

            // リクエストを送信
            xhr.send("memoTitle=" + selectedTitle);
        }
    } else {
        alert("メモを選択してください");
    }
}