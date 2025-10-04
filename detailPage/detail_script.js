const urlParams = new URLSearchParams(window.location.search);
const pid = urlParams.get("id");

if (!pid || !/^[a-f0-9]{16}$/i.test(pid)) {
    document.body.innerHTML = "<p>ID 오류</p>";
} else {
    fetch("detail?pid=" + encodeURIComponent(pid))
        .then(res => {
            if (!res.ok) throw new Error("서버 오류");
            return res.json();
        })
        .then(data => {
            if (!data.ok) {
                document.body.innerHTML = "<p>" + (data.error || "찾을 수 없음") + "</p>";
                return;
            }

            const post = data.post;

            document.querySelector("#title").textContent = post.title;
            const formattedPrice = Math.round(parseFloat(post.price)).toLocaleString('ko-KR') + "원";
            document.querySelector("#price").textContent = formattedPrice;
            document.querySelector("#content").textContent = post.content;
            const date = new Date(post.created_at);
            const formattedDate = `${date.getFullYear()}년 ${date.getMonth() + 1}월 ${date.getDate()}일 ${date.getHours()}시 ${date.getMinutes()}분`;
            document.querySelector("#created_at").textContent = formattedDate;
            document.querySelector("#author").textContent = post.author_login_id;

            const gallery = document.querySelector("#gallery");
            gallery.innerHTML = "";
            let images = [];
            try {
                images = JSON.parse(post.image_paths || "[]");
            } catch (e) {
                console.error("파싱 오류:", e);
            }

            images.forEach(path => {
                const img = document.createElement("img");
                img.src = path;
                img.alt = "post image";
                gallery.appendChild(img);
            });
            
            setupSlider();
        })
        .catch(err => {
            console.error(err);
            document.body.innerHTML = "<p>불러오는 중 오류</p>";
        });
}


function setupSlider() {
    const slider = document.getElementById("gallery");
    const images = slider.querySelectorAll("img"); 
    const dotsContainer = document.getElementById("sliderDots");
    const sliderWrapper = document.getElementById("sliderWrapper");
    let currentIndex = 0;

    if (images.length === 0) return;

    function updateSlider() {
        const offset = -currentIndex * 100;
        slider.style.transform = `translateX(${offset}%)`;
        updateDots();
    }

    function updateDots() {
        dotsContainer.innerHTML = '';
        images.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            dot.classList.toggle('active', index === currentIndex);
            dotsContainer.appendChild(dot);
        });
    }

    sliderWrapper.addEventListener("click", (e) => {
        if (images.length <= 1) return;
        const wrapperWidth = sliderWrapper.offsetWidth;
        const clickX = e.offsetX;

        if (clickX < wrapperWidth / 2) {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
        } else {
            currentIndex = (currentIndex + 1) % images.length;
        }
        updateSlider();
    });

    updateSlider();
}

// ✅ 매칭 버튼 처리
document.getElementById("matchBtn").addEventListener("click", function () {
    const matchBtn = this;
    const isMatched = matchBtn.classList.contains("matched");

    if (isMatched) {
        return; // 이미 매칭중이면 중복 요청 방지
    }

    fetch('match', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ pid: pid }), // pid만 전송
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('서버 오류');
        }
        return res.json();
    })
    .then(data => {
        if (data.ok) {
            matchBtn.classList.add("matched");
            matchBtn.textContent = "매칭중";
            alert("매칭 요청 완료");
        } else {
            alert("매칭 실패: " + (data.error || "알 수 없는 오류"));
            console.error("매칭 실패:", data.error);
        }
    })
    .catch(err => {
        alert("오류가 발생했습니다.");
        console.error("매칭 에러:", err);
    });
});


// =====================
// 검색창 관련 코드 (기존 그대로)
// =====================
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
