document.addEventListener('DOMContentLoaded', init);
const postContainer = document.getElementById('post-container');
const paginationUl = document.querySelector('.button ul');
const searchForm = document.querySelector('.search-box form');
const searchInput = document.querySelector('.search-input');
const sortRecentRadio = document.getElementById('distance');
const sortPriceRadio = document.getElementById('fast');
const lowPriceBtn = document.querySelector('.low-price');
const highPriceBtn = document.querySelector('.high-price');
const postsPerPage = 10;
let state = { q: '', sort: 'recent', page: 1 };


function readStateFromURL() {
    const u = new URL(location.href);
    state.q = u.searchParams.get('q') || '';
    state.sort = u.searchParams.get('sort') || 'recent';
    state.page = Math.max(1, parseInt(u.searchParams.get('page') || '1', 10));
}
function writeStateToURL({ replace = false } = {}) {
    const u = new URL(location.href);
    if (state.q) u.searchParams.set('q', state.q); else u.searchParams.delete('q');
    u.searchParams.set('sort', state.sort);
    u.searchParams.set('page', String(state.page));
    const url = u.toString();
    replace ? history.replaceState(null, '', url) : history.pushState(null, '', url);
}
function applyStateToUI() {
    if (searchInput) searchInput.value = state.q;
    if (sortRecentRadio) sortRecentRadio.checked = (state.sort === 'recent');
    if (sortPriceRadio) sortPriceRadio.checked = (state.sort === 'price_asc' || state.sort === 'price_desc');

    lowPriceBtn?.classList.toggle('active', state.sort === 'price_asc');
    highPriceBtn?.classList.toggle('active', state.sort === 'price_desc');
}

async function fetchPostsFromServer() {
    const params = new URLSearchParams({
        page: String(state.page),
        limit: String(postsPerPage),
        sort: state.sort
    });
    if (state.q) params.set('q', state.q);

    const res = await fetch(`list?${params.toString()}`, {
        method: 'GET',
        headers: { 'Accept': 'application/json' }
    });
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
}
async function load({ replaceURL = false } = {}) {
    applyStateToUI();
    try {
        const resp = await fetchPostsFromServer();
        state.page = resp.page || state.page;
        displayPosts(resp.items || []);
        setupPagination(resp.totalPages || 0, state.page);
        if (replaceURL) writeStateToURL({ replace: true });
    } catch (e) {
        console.error(e);
        postContainer.innerHTML = '<p>목록을 불러오는 중 오류가 발생했습니다</p>';
        paginationUl.innerHTML = '';
    }
}

function displayPosts(items) {
    postContainer.innerHTML = '';
    if (!items.length) {
        postContainer.innerHTML = '<p>게시글이 없습니다</p>';
        return;
    }
    items.forEach(post => {
        const card = document.createElement(post.public_id ? 'a' : 'div');
        if (post.public_id) card.href = `/detailPage/detail2.php?id=${encodeURIComponent(post.public_id)}`;
        card.className = 'box';

        const img = document.createElement('img');
        img.className = 'list-img';
        img.src = post.image;
        img.alt = post.title ?? '';

        const margin = document.createElement('div');
        margin.className = 'margin1';

        const info = document.createElement('div');
        info.className = 'box1';

        const title = document.createElement('p');
        title.className = 'nanum-gothic-regular post-title';
        title.textContent = post.title ?? '';

        const price = document.createElement('p');
        price.className = 'nanum-pen-script-regular post-price';
        if (typeof post.price === 'number') price.textContent = `${post.price.toLocaleString()}원`;

        info.append(title, price);
        card.append(img, margin, info);
        postContainer.appendChild(card);
    });
}

function setupPagination(totalPages, currentPage) {
    paginationUl.innerHTML = '';
    if (!totalPages || totalPages < 1) return;

    const start = Math.floor((currentPage - 1) / 5) * 5 + 1;
    const end = Math.min(start + 4, totalPages);

    const add = (label, target, { active = false } = {}) => {
        const li = document.createElement('li');
        const a = document.createElement('a');
        a.href = '#';
        a.textContent = label;
        if (active) {
            a.style.fontWeight = 'bold';
            a.style.color = '#ff8352';
            a.style.pointerEvents = 'none';
        } else {
            a.addEventListener('click', (e) => {
                e.preventDefault();
                state.page = target;
                writeStateToURL();
                load();
            });
        }
        li.appendChild(a);
        paginationUl.appendChild(li);
    };

    if (start > 1) add('이전', start - 1);
    for (let p = start; p <= end; p++) add(String(p), p, { active: p === currentPage });
    if (end < totalPages) add('다음', end + 1);
}


const priceLabel = document.querySelector('.container-2');

function bindEvents() {
    searchForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        state.q = (searchInput?.value || '').trim();
        state.page = 1;
        writeStateToURL();
        load();
    });


    sortRecentRadio?.addEventListener('change', () => {
        state.sort = 'recent';
        state.page = 1;
        writeStateToURL();
        load();
    });

    sortPriceRadio?.addEventListener('change', () => {
        if (state.sort !== 'price_asc' && state.sort !== 'price_desc') {
            state.sort = 'price_asc';
        }
        priceLabel.childNodes[0].nodeValue = '낮은가격순 ';
        state.page = 1;
        writeStateToURL();
        load();
    });

    lowPriceBtn?.addEventListener('click', () => {
        state.sort = 'price_asc';
        priceLabel.childNodes[0].nodeValue = '낮은가격순 ';
        state.page = 1;
        writeStateToURL();
        load();
    });

    highPriceBtn?.addEventListener('click', () => {
        state.sort = 'price_desc';
        priceLabel.childNodes[0].nodeValue = '높은가격순 ';
        state.page = 1;
        writeStateToURL();
        load();
    });

    window.addEventListener('popstate', () => {
        readStateFromURL();
        load({ replaceURL: true });
    });
}

window.refreshPostsAfterCRUD = function () {
    load();
};

function init() {
    readStateFromURL();
    bindEvents();
    load({ replaceURL: true });
}

// 검색
const historyDropdown = document.querySelector('.search-dropdown');
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