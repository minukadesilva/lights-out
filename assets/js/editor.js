const textarea = document.getElementById("content");
const preview = document.getElementById("preview");

textarea.addEventListener("input", updatePreview);

function updatePreview() {

    let text = textarea.value;

    text = text.replace(/^# (.*)$/gm, "<h1>$1</h1>");
    text = text.replace(/^## (.*)$/gm, "<h2>$1</h2>");

    text = text.replace(/\*\*(.*?)\*\*/g, "<strong>$1</strong>");

    text = text.replace(/\*(.*?)\*/g, "<em>$1</em>");

    text = text.replace(/\n/g, "<br>");

    preview.innerHTML = text;
}

function insertMarkdown(type) {

    const start = textarea.selectionStart;
    const end = textarea.selectionEnd;

    const selected = textarea.value.substring(start, end);

    let markdown = "";

    switch (type) {

        case "bold":
            markdown = `**${selected}**`;
            break;

        case "italic":
            markdown = `*${selected}*`;
            break;

        case "h1":
            markdown = `# ${selected}`;
            break;

        case "h2":
            markdown = `## ${selected}`;
            break;

        case "list":
            markdown = `- ${selected}`;
            break;
    }

    textarea.setRangeText(markdown);
    updatePreview();
}