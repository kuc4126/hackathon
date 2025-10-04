const searchInput = document.querySelector('.search-input');
const historyDropdown = document.querySelector('.search-dropdown');
const searchForm = document.querySelector('.search-box form');
const searchButton = document.querySelector('.search-box button');
const maxDropdownNumber = 5
let searchDebounceTimeout;
const searchDebounceDelay = 200;
let abortController = null;

if (searchForm) {
    searchForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        const keywordToSend = searchInput.value.trim();

        if (keywordToSend) {
            try {
                const response = await fetch('search', {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ query: keywordToSend }),
                });

                const result = await response.json();
                console.log(result);

            } catch (error) {
                console.error(error);
                alert('검색 요청 중 오류가 발생했습니다.');
            }
        } else {
            alert('검색어를 입력해주세요.');
            searchInput.focus();
        }
    });
}

searchInput.addEventListener("keyup", function(){
    const currentValue = this.value.trim();

    clearTimeout(searchDebounceTimeout);
    if (abortController) {
        abortController.abort();
    }
    if (!currentValue) {
        historyDropdown.innerHTML = "";
        historyDropdown.classList.remove('active');
        abortController = null;
        return;
    }

    abortController = new AbortController();
    const signal = abortController.signal;

    // 디바운싱
    searchDebounceTimeout = setTimeout(async () => {
        if (currentValue !== searchInput.value.trim()) {
            return;
        }

        console.log(`서버에 추천 검색어 요청: ${currentValue}`);
        try {
            const response = await fetch(`searchKeyword?q=${encodeURIComponent(currentValue)}`, { signal }); // signal 전달

            if (signal.aborted) {
                console.log('Fetch aborted');
                return;
            }
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const suggestions = await response.json();
            abortController = null; 
            historyDropdown.innerHTML = "";

            if (!searchInput.value.trim() || !suggestions || suggestions.length === 0) {
                historyDropdown.classList.remove('active');
                return;
            }

            const limitedKeyword = suggestions.slice(0, maxDropdownNumber);
            const keywordElements = limitedKeyword.map(item => `<div class="search-relevant-keyword"><p>${item}</p></div>`);
            historyDropdown.innerHTML = keywordElements.join('');
            historyDropdown.classList.add('active');

        } 
        catch (error) {
            abortController = null;
            if (error.name === 'AbortError') {
                console.log('Previous suggestion fetch aborted.');
            } else {
                console.error('검색어 로딩 중 오류 발생:', error);
                historyDropdown.innerHTML = "";
                historyDropdown.classList.remove('active');
            }
        }
    }, searchDebounceDelay);
});

document.addEventListener("click", function(event){
    if (historyDropdown && historyDropdown.classList.contains('active')) {
        if (!historyDropdown.contains(event.target) && !searchInput.contains(event.target)) {
            historyDropdown.classList.remove('active');
        }
    }
});

if (historyDropdown) { 
    historyDropdown.addEventListener('click', function(event){
        const clickedKeywordElement = event.target.closest('.search-relevant-keyword');

        if (clickedKeywordElement) {
            const selectedKeyword = clickedKeywordElement.textContent.trim();
            searchInput.value = selectedKeyword;
            historyDropdown.classList.remove('active');
            historyDropdown.innerHTML = "";
            searchInput.focus();
        }
    });
}

// 작성

const imageSection = document.getElementById("imageSection");
const imageInputs = [];
let imagePreviewCount = 0;
let totalImageInputCount = 0;
const fileNames = [];

const fileNameDisplay = document.createElement("div");
if (imageSection) { 
    fileNameDisplay.style.marginTop = "0px";
    fileNameDisplay.style.fontSize = "14px";
    fileNameDisplay.style.textAlign = "left";
    fileNameDisplay.style.width = "100%";
    imageSection.appendChild(fileNameDisplay);
}

function updateFileNameDisplay() {
    if (fileNames.length > 0) {
        fileNameDisplay.textContent = "첨부된 이미지: " + fileNames.join(", ");
    } else {
        fileNameDisplay.textContent = "";
    }
}

function createImageInputButton() {
    if (!imageSection) return; 
    const wrapper = document.createElement("div");
    wrapper.className = "image-wrapper";
    const inputId = "imageInput_" + Date.now() + "_" + Math.random().toString(36).substring(2, 7); // 고유 ID 생성 강화
    const input = document.createElement("input");
    input.type = "file";
    input.accept = "image/*";
    input.id = inputId;
    input.style.display = "none";
    imageInputs.push(input);
    const button = document.createElement("button");
    button.type = "button";
    button.textContent = "사진";
    button.className = "nanum-gothic-regular img-button";
    const imgPreview = document.createElement("img");
    imgPreview.style.display = "none";
    imgPreview.style.objectFit = "cover";
    imgPreview.style.border = "1px solid #ccc";
    imgPreview.className = "img";
    button.onclick = () => input.click();
    input.onchange = (e) => {
        const file = e.target.files[0];
        if (file) {
            if (fileNames.includes(file.name)) {
                showAlert("중복된 이미지는 첨부할 수 없습니다.");
                input.value = "";
                return;
            }

            fileNames.push(file.name);
            updateFileNameDisplay();

            if (imagePreviewCount < 3) { // 3개까지
                const reader = new FileReader();
                reader.onload = (event) => {
                    imgPreview.src = event.target.result;
                    imgPreview.style.display = "block";
                    button.style.display = "none";
                    wrapper.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
                imagePreviewCount++;

                if (totalImageInputCount < 2) {
                    createImageInputButton();
                    totalImageInputCount++;
                }
            } else {
                const reader = new FileReader();
                reader.onload = (event) => {
                    imgPreview.src = event.target.result;
                    imgPreview.style.display = "block";
                    button.style.display = "none";
                    wrapper.appendChild(imgPreview);
                };
                reader.readAsDataURL(file);
            }
        }
    };

    wrapper.appendChild(input);
    wrapper.appendChild(button);
    imageSection.insertBefore(wrapper, fileNameDisplay);
}

if (imageSection) {
    createImageInputButton();
    totalImageInputCount = 0;
}


const hashtagInput = document.getElementById("hashtag");
const hashtagList = document.getElementById("hashtagList");

if (hashtagInput && hashtagList) {
    hashtagInput.addEventListener("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault();
            const tag = hashtagInput.value.trim();
            if (tag !== "") {
                if (hashtagList.children.length >= 10) { // 해시태그 10개까지
                    showAlert("해시태그는 최대 10개까지 추가할 수 있습니다.");
                    return;
                }
                const span = document.createElement("div");
                span.className = "hashtag nanum-pen-script-regular";
                span.textContent = "#" + tag;
                span.addEventListener('click', function () {
                    this.remove();
                });

                hashtagList.appendChild(span);
                hashtagInput.value = "";
            }
        }
    });
}

function showAlert(message) {
    const customAlert = document.getElementById("customAlert");
    const alertMessage = document.getElementById("alertMessage");
    if (customAlert && alertMessage) {
        alertMessage.textContent = message;
        customAlert.style.display = "block";
    } else {
        alert(message);
    }
}

function closeAlert() {
    const customAlert = document.getElementById("customAlert");
    if (customAlert) {
        customAlert.style.display = "none";
    }
}

const uploadButton = document.querySelector(".upload-section button");

if (uploadButton) { 
    uploadButton.addEventListener("click", async function () {
        const titleInput = document.getElementById("title");
        const priceInput = document.getElementById("price");
        const contentInput = document.getElementById("content");
        const sponsorInput = document.getElementById("sponsor");

        if (!titleInput || !priceInput || !contentInput || !sponsorInput || !hashtagList) {
            showAlert("페이지 구성 요소를 찾을 수 없습니다. 다시 시도해주세요.");
            return;
        }

        const title = titleInput.value.trim();
        const price = priceInput.value.trim();
        const content = contentInput.value.trim();
        const hashtags = Array.from(hashtagList.querySelectorAll(".hashtag")).map(tag => tag.textContent.substring(1)); // # 제거
        const sponsor = sponsorInput.checked;

        if (!title) {
            showAlert("제목을 입력해주세요");
            titleInput.focus();
            return;
        }

        if (!price) {
            showAlert("가격을 입력해주세요");
            priceInput.focus();
            return;
        }

        if (isNaN(parseFloat(price))) {
            showAlert("가격은 숫자로 입력해주세요");
            priceInput.focus();
            return;
        }

        if (!content) {
            showAlert("내용을 입력해주세요");
            contentInput.focus();
            return;
        }

        const formData = new FormData();
        formData.append("title", title);
        formData.append("price", price);
        formData.append("content", content);
        formData.append("sponsor", sponsor.toString());
        hashtags.forEach(tag => {
            formData.append("hashtags[]", tag);
        });
        const filesToUpload = imageInputs.filter(input => input.files && input.files.length > 0);
        filesToUpload.forEach((input, index) => {
            if (input.files[0]) {
                formData.append(`images[]`, input.files[0], input.files[0].name); 
            }
        });

        uploadButton.disabled = true;
        uploadButton.textContent = "업로드 중...";

        try {
            const response = await fetch('write', {
                method: 'POST',
                body: formData,
            });

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({ message: '서버 응답 오류' }));
                throw new Error(`서버 오류: ${response.status} - ${errorData.message || response.statusText}`);
            }

            const result = await response.json();
            console.log(result);

            if (result.ok && (result.detail_url || result.public_id)) {
                const url = result.detail_url
                    ? result.detail_url
                    : `/detailPage/index.php?id=${encodeURIComponent(result.public_id)}`;
                window.location.href = url;
                return;
            }
            throw new Error(result.message || '업로드 실패');
        } catch (error) {
            console.error('게시글 전송 중 오류 발생:', error);
            showAlert(`업로드 실패: ${error.message}`);
        } finally {
            uploadButton.disabled = false;
            uploadButton.textContent = "업로드";
        }

    });
}