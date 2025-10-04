document.addEventListener('DOMContentLoaded', function () {
    const signUpForm = document.querySelector('#signUp .join_membership');
    const phoneNumberInput = document.getElementById('phoneNumber');
    const emailInput = document.getElementById('email');
    const id1Input = document.getElementById('ID1');
    const password1Input = document.getElementById('password1');
    const clauseCheckbox = document.getElementById('clause');
    const personalInfoCheckbox = document.getElementById('personalInformation');

    const logInForm = document.querySelector('#logIn .join_membership');
    const id2Input = document.getElementById('ID2');
    const password2Input = document.getElementById('password2');

    const loginButton = document.getElementById('logInChange');
    const signUpElement = document.getElementById('signUp');
    const signupButton = document.getElementById('signUpChange');
    const loginElement = document.getElementById('logIn');

    if (signUpForm) {
        signUpForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const sPhoneNumber = phoneNumberInput.value;
            const sEmail = emailInput.value;
            const sId = id1Input.value;
            const sPassword = password1Input.value;
            const agreedClause = clauseCheckbox.checked;
            const agreedPersonalInfo = personalInfoCheckbox.checked;

            if (!agreedClause || !agreedPersonalInfo) {
                alert("약관 및 개인정보 수집에 모두 동의해야 합니다");
                return;
            }

            const signUp = {
                PhoneNumber: sPhoneNumber,
                email: sEmail,
                id: sId,
                password: sPassword
            };

            fetch('signup', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(signUp)
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => { throw new Error(err.message || '회원가입 처리 중 문제 발생'); });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        alert(data.message);
                        signUpElement.classList.add('hidden');
                        loginElement.classList.remove('hidden');
                        loginElement.classList.add('hiddenOut');
                    }
                    else if (data.status === 'fail') {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch 오류:', error);
                });
        });
    }

    if (logInForm) {
        logInForm.addEventListener('submit', function (event) {
            event.preventDefault();
            const lId = id2Input.value;
            const lPassword = password2Input.value;

            const logIn = {
                id: lId,
                password: lPassword
            };

            fetch('login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                credentials: 'include',
                body: JSON.stringify(logIn)
            })

                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        window.location.href = "https://www.sosege.store";
                    } else {
                        alert(data.message);
                    }
                });
        });
    }

    loginElement.classList.remove('hidden');
    signUpElement.classList.add('hidden');

    if (loginButton) {
        loginButton.addEventListener('click', function () {
            if (signUpElement) {
                signUpElement.classList.add('hidden');
                loginElement.classList.remove('hidden');
                loginElement.classList.add('hiddenOut');
            }
        });
    }
    if (signupButton) {
        signupButton.addEventListener('click', function () {
            if (loginElement) {
                loginElement.classList.add('hidden');
                signUpElement.classList.add('hiddenOut');
                signUpElement.classList.remove('hidden');
            }
        });
    }
});

// 검색
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