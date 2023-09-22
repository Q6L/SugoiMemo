function saveMemo() {
    var memoText = document.getElementById("memoInput").value;
    
    var blob = new Blob([memoText], {type: "text/plain"});
    var url = URL.createObjectURL(blob);
    
    var a = document.createElement("a");
    a.href = url;
    a.download = "memo.txt";
    a.click();
  }

function countCharacters(textarea) {
    const characterCountElement = document.getElementById("characterCount");
    const characterCount = textarea.value.length;
    characterCountElement.textContent = characterCount + "文字";
}
