

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


// 슬라이드
const left = document.querySelector('.slide-left')
const right = document.querySelector('.slide-right')
const track = document.querySelector('.slide-track')
const slide = document.querySelectorAll('.slide')
const slength = slide ? slide.length : 0;
let current = 1

const move = function(n){
    if (!track) return;
    track.style.transform = `translateX(${-n * 100}%)`;
    current = n;
}

if (track && slength > 0) {
    track.style.transition = 'none';
    current = 1;
    track.style.transform = `translateX(${-100}%)`;
}

if (left && track) {
    left.addEventListener('click', ()=>{
        track.style.transition = `transform ${500 / 1000}s ease`;
        if(current > 0){
            move(current - 1)
        }
    });
}

if (right && track && slength > 0) {
    right.addEventListener('click', ()=>{
        track.style.transition = `transform ${500 / 1000}s ease`;
        if(current < slength - 1){
            move(current + 1)
        }
    });
}

if (track && slength > 0) {
    track.addEventListener('transitionend', () => {
        if(current === 0) {
            track.style.transition = 'none';
            current = slength - 2;
            track.style.transform = `translateX(${-(slength - 2) * 100}%)`;
        } else if(current === slength - 1) {
            track.style.transition = 'none';
            current = 1;
            track.style.transform = `translateX(${-100}%)`;
        }
    });
}



/**
 * 
 * @param {string} apiUrl
 */
async function fetchAndUpdateRecommendations(apiUrl = 'recommendations') {
    try {
        const response = await fetch(apiUrl);

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        console.log('Received data:', data);

        if (data.box1) {
            const box1 = data.box1;
            document.querySelector('.recommendation-box-1-image').style.backgroundImage = `url('${box1.backgroundImg}')`;
            document.querySelector('.recommendation-box-1-title').textContent = box1.title;
            document.querySelector('.recommendation-box-1-content').textContent = box1.text;
            document.querySelector('.recommendation-box-1-price').textContent = `${new Intl.NumberFormat('ko-KR').format(parseFloat(box1.price))}원`;
        }

        if (data.box2) {
            const box2 = data.box2;
            document.querySelector('.recommendation-box-2-image').style.backgroundImage = `url('${box2.backgroundImg}')`;
            document.querySelector('.recommendation-box-2-title').textContent = box2.title;
            document.querySelector('.recommendation-box-2-content').textContent = box2.text;
            document.querySelector('.recommendation-box-2-price').textContent = `${new Intl.NumberFormat('ko-KR').format(parseFloat(box2.price))}원`;
        }
    } catch (error) {
        console.error(error);
        alert('실패했습니다');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    fetchAndUpdateRecommendations('recommendations');
});


document.addEventListener('DOMContentLoaded', () => {
    fetchAndUpdateRecommendations('recommendations');
});