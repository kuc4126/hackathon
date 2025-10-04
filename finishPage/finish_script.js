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

document.addEventListener('DOMContentLoaded', async () => {
    const matchingContentElement = document.querySelector('.matching-content');
    
    if (matchingContentElement) {
        try {
            const response = await fetch('matching-result'); 
            const data = await response.json();

            if (data && data.message) {
                matchingContentElement.textContent = data.message; 
            } else {
                console.error('형식 오류:', data);
                matchingContentElement.textContent = '불러오는 데 실패했습니다'; 
            }

        } catch (error) {
            console.error('내용 로딩 중 발생:', error);
            matchingContentElement.textContent = '불러오는 중 오류가 발생했습니다';
        }
    } else {
    }
});