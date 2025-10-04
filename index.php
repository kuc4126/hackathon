<?php
// 반드시 session_start() 전에!
session_set_cookie_params([
    'path' => '/',           // 루트 경로 전체에서 세션 쿠키 유효
    'httponly' => true,      // JS 접근 불가 (보안 강화)
    'secure' => false,       // HTTPS만 쓸 경우 true
    'samesite' => 'Lax'      // 크로스 사이트 요청 대응
]);

session_start();
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SOSEGE</title>
        <link rel="stylesheet" href="style.css?v=1.3">
        <link rel="icon" href="detailPage/images/favicon.png" type="image/x-icon">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Anton&family=Black+Han+Sans&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Monoton&family=Nanum+Gothic&family=Nanum+Pen+Script&family=Noto+Sans+KR:wght@100..900&family=Orbitron:wght@400..900&display=swap" rel="stylesheet">
    </head>
    <body>
        <header>
            <div class="hambuger-icon"></div>
            <div class="hambuger-bar">
                <div><div class="hambuger-back"></div></div>
                <ul class="hambuger-bar-menu">
                    <a href="/searchPage/search.php"><li class="nanum-gothic-regular">검색</li></a>
                    <a href="/listPage/listPage2.php"><li class="nanum-gothic-regular">추천</li></a>
                    <a href="/writePage/write.php"><li class="nanum-gothic-regular">글쓰기</li></a>
                    <a href="#"><li class="nanum-gothic-regular">이벤트</li></a>
                    <a href="#"><li class="nanum-gothic-regular">고객센터</li></a>
                    <a href="/sign_up/signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>


                    <a href="/profilePage/profile.php"><li class="nanum-gothic-regular">프로필</li></a>
                </ul>
                <div>
                    <img src="images/logo.png" alt="소새지 로고" class="hambuger-bar-logo">
                </div>
            </div>
            <a href="#"><img src="images/logo_classic.png" alt="소세지 로고" class="logo"></a>
            <div class="search-box">
                <form action="#">
                    <div>
                        <input type="text" name="search" placeholder="음식 키워드를 입력해주세요" autocomplete="off" class="search-input nanum-pen-script-regular" spellcheck="false">
                        <div class="search-dropdown-box"><div class="search-dropdown"></div></div>
                    </div>
                    <button><img src="images/icon_search.png" alt="검색"></button>
                </form>
            </div>
            <div>
                <?php if (isset($_SESSION['user_id'])): ?>
                    
                <?php else: ?>
                    <p class="nanum-gothic-regular">|</p>
                    <a href="/sign_up/signUp.php" class="signIn-button"><p class="nanum-gothic-regular">로그인</p></a>
                    <p class="nanum-gothic-regular">|</p>
                    <a href="/sign_up/signUp.php" class="signUp-button"><p class="nanum-gothic-regular">회원가입</p></a>
                <?php endif; ?>
                
                
                <p class="nanum-gothic-regular">|</p>


                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/profilePage/profile.php" class="profile-button"><div></div></a>
                <?php else: ?>
                    <a href="/sign_up/signUp.php" onclick="alert('로그인이 필요합니다.');" class="profile-button"><div></div></a>
                <?php endif; ?>
                <p class="nanum-gothic-regular">|</p>


            </div>
        </header>
        <nav>
            <div>
                <ul class="navigation-bar-default">
                    <p class="nanum-gothic-regular">|</p>
                    <a href="/searchPage/search.php"><li class="nanum-gothic-regular">검색</li></a>
                    <p class="nanum-gothic-regular">|</p>
                    <a href="/listPage/listPage2.php"><li class="nanum-gothic-regular">추천</li></a>
                    <p class="nanum-gothic-regular">|</p>
                    <!-- <a href="/writePage/write.html"><li class="nanum-gothic-regular">글쓰기</li></a> -->
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="/writePage/write.php">
                            <li class="nanum-gothic-regular">글쓰기</li>
                        </a>
                    <?php else: ?>
                        <a href="/sign_up/signUp.php" onclick="alert('로그인이 필요합니다.');">
                            <li class="nanum-gothic-regular">글쓰기</li>
                        </a>
                    <?php endif; ?>
                    
                    <p class="nanum-gothic-regular">|</p>
                    <a href="#"><li class="nanum-gothic-regular">이벤트</li></a>
                    <p class="nanum-gothic-regular">|</p>
                    <a href="#"><li class="nanum-gothic-regular">고객센터</li></a>
                    <p class="nanum-gothic-regular">|</p>
                </ul>

                
                <ul class="navigation-bar-update">
                    <?php if (!isset($_SESSION['user_id'])): ?>
                        <a href="/sign_up/signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>
                        <p class="nanum-gothic-regular">|</p>
                    <?php else: ?>
                        <a href="/profilePage/profile.php"><li class="nanum-gothic-regular">프로필</li></a>
                        <p class="nanum-gothic-regular">|</p>
                    <?php endif; ?>
                </ul>



            </div>
        </nav>
        <div class="main-footer">
            <main>
                <section class="slide-container">
                    <div class="slide-track">
                        <div class="slide slide-3-clone">
                            <img src="images/1_banner.png" alt="배너이미지3" class="banner-img">
                        </div>
                        <div class="slide slide-1">
                            <img src="images/2_banner.png" alt="배너이미지1" class="banner-img">
                        </div>
                        <div class="slide slide-2">
                            <img src="images/3_banner.png?v=1.1" alt="배너이미지2" class="banner-img">
                        </div>
                        <div class="slide slide-3">
                            <img src="images/1_banner.png" alt="배너이미지3" class="banner-img">
                        </div>
                        <div class="slide slide-1-clone">
                            <img src="images/2_banner.png" alt="배너이미지1" class="banner-img">
                        </div>
                    </div>
                    <div class="slide-button">
                        <div class="slide-left"><img src="images/icon_lt.png" alt="왼쪽으로 넘기기"></div>
                        <div class="slide-right"><img src="images/icon_gt.png" alt="오른쪽으로 넘기기"></div>
                    </div>
                </section>
                <div class="margin"></div>
                <section class="recommendation-container">
                    <div><h2 class="recommendation-text black-han-sans-regular">소새지<br>오늘의 추천</h2></div>
                    <div class="recommendation-boxes">
                        <ul>
                            <li>
                                <article class="recommendation-box recommendation-box-1">
                                    <div class="recommendation-box-1-image"></div>
                                    <div class="recommendation-box-1-text">
                                        <dl>
                                            <dt class="recommendation-box-1-title"></dt>
                                            <dd class="recommendation-box-1-content"></dd>
                                            <dd class="recommendation-box-1-price"></dd>
                                        </dl>
                                    </div>
                                </article>
                            </li>
                            <li>
                                <article class="recommendation-box recommendation-box-2">
                                    <div class="recommendation-box-2-image"></div>
                                    <div class="recommendation-box-2-text">
                                        <dl>
                                            <dt class="recommendation-box-2-title"></dt>
                                            <dd class="recommendation-box-2-content"></dd>
                                            <dd class="recommendation-box-2-price"></dd>
                                        </dl>
                                    </div>
                                </article>
                            </li>
                        </ul>
                    </div>
                </section>
                <div class="margin"></div>
                <section class="description-container">
                    <article class="description-box">
                        <dl>
                            <dt class="orbitron-800 sosege-title">소새지&#40;SOSEGE&#41;</dt>
                            <dd class="noto-sans-kr-400 sosege-summary"><span class="bold">소새지(소소한 새활용 지향, SOSEGE)</span> 프로젝트는 버려질 뻔한 음식물을 필요한 사람에게 연결하여 음식물 쓰레기 문제와 사회적 약자의 식사 문제를 동시에 해결하고자 기획된 서비스입니다.</dd>
                            <dd class="sosege-goals">
                                <p class="bold">주요 목표는 다음과 같습니다:</p>
                                <ul class="sosege-goals-list">
                                    <div><span></span><li class="noto-sans-kr-400">유통기한이 임박하거나 남는 식자재를 합리적인 가격에 판매하거나 기부로 전환합니다.</li></div>
                                    <div><span></span><li class="noto-sans-kr-400">음식물 낭비를 줄이고, 취약계층에게 실질적인 식사 지원을 확대합니다.</li></div>
                                    <div><span></span><li class="noto-sans-kr-400">ESG 트렌드에 부합하는 사회적 가치를 창출합니다.</li></div>
                                </ul>
                            </dd>
                            <dd class="noto-sans-kr-400 sosege-description">이를 통해 <span class="bold">음식물 쓰레기 절감</span>, <span class="bold">판매자와 소비자의 비용 절감</span>, <span class="bold">취약계층 지원 및 나눔 문화 확산</span> 등의 효과를 기대합니다. 궁극적으로는 낭비 없는 사회를 만들고 지속 가능한 공유경제 플랫폼으로 성장하는 것을 비전으로 삼고 있습니다.</dd>
                        </dl>
                    </article>
                </section>
                <div class="margin"></div>
                <section class="introduce-container">
                    <div class="introduce-box introduce-box-1">
                        <img src="images/area_1.png" alt="팀소개" class="area-img">
                    </div>
                    <div class="introduce-box introduce-box-2">
                        <img src="images/area_2.png" alt="디자인가이드" class="area-img">
                    </div>
                </section>
                <div class="margin"></div>
                <section class="article-container">
                    <ul class="article-boxes">
                        <li>
                            <article class="article">
                                <div class="article-media">
                                    <a href="https://www.hani.co.kr/arti/society/environment/1120320.html" target="_blank">
                                        <div class="article-1-image"></div>
                                    </a>
                                </div>
                                <div class="article-text">
                                    <div class="article-title-box-cover">
                                        <div class="article-title-box article-title-box-1">
                                            <a href="https://www.hani.co.kr/arti/society/environment/1120320.html" target="_blank">
                                                <h3 class="article-title black-han-sans-regular rgb202020">Q. 음식물쓰레기 많이 버리면<br>&#39;기후악당&#39;이 되나요?</h3>
                                            </a>
                                        </div>
                                        <div class="article-title-box-border">
                                            <h3 class="please-please black-han-sans-regular">제<br>발</h3>
                                            <div class="special-border-please"></div>
                                        </div>
                                    </div>
                                    <div class="margin-20-box">
                                        <div class="margin-20"><div class="special-border-please-2"></div></div>
                                        <div class="margin-20-border"></div>
                                    </div>
                                    <div class="article-content-box">
                                        <div class="date-and-margin-border">
                                            <div><p class="article-date nanum-gothic-regular rgb202020">2023.12.14</p></div>
                                            <div><p class="article-sources nanum-gothic-regular rgb202020">한겨레<span class="sortation"> | </span>신소윤 기자<span class="gap">공</span></p></div>
                                        </div>
                                        <a href="https://news.kbs.co.kr/news/pc/view/view.do?ncd=5444577" target="_blank">
                                            <div class="article-content">
                                                <p class="article-content-summary nanum-gothic-regular rgb202020">
                                                    &emsp;A. 우리가 매일 버리는 음식물쓰레기는 대개 매립지에 묻히게 되는데, 부패 과정에서 온실가스의 하나인 ‘메탄’을 뿜어냅니다. 메탄은 이산화탄소보다 빨리 사라지긴 하지만 온실가스 효과가 80배에 달합니다. 온실가스는 기후변화를 일으키고, 농업 의존도가 높은 가난한 나라는 기후변화의 직격탄을 맞아 심각한 기근에 시달립니다. 한쪽은 먹을 것이 넘쳐 버리면서 온실가스를 뿜어내고, 반대쪽은 그 악영향을 고스란히 받게되는 거죠. 그러니 음식물쓰레기를 많이 버리게 되면, 기후변화 유발은 물론 기후위기로 인한 불평등이라는 악순환의 고리에 어느 정도 일조한다고 볼 수 있습니다.

                                                    아랍에미리트 두바이에서 열린 제28차 유엔기후변화협약 당사국총회(COP28)에서는 총회 역사상 처음으로 식량난과 기후위기의 긴밀한 관계가 집중 조명됐습니다. 국제 환경단체인 천연자원보호협회(NRDC)는 이와 관련 “기후위기 논의에서 그간 식량 및 농업 문제는 일반적으로 간과돼왔는데, 세계적인 식품 시스템은 온실가스를 다량 배출하고 있다”고 지적했습니다.
                                                    
                                                    유엔(UN)은 식품의 재배-가공-유통-소비-폐기 전 단계에서 온실가스가 발생한다고 얘기합니다. 작물의 성장을 돕는 비료에선 아산화질소가 나오고, 소를 비롯한 축산동물은 소화 과정에서 메탄을 뿜어냅니다. 농경지 확장을 위해 숲을 태우면 이산화탄소가 대량 발생합니다. 농장에서 사용하는 연료나 식품의 냉장 및 운송, 포장용기 생산 과정에도 각종 온실가스가 발생하는데, 생산된 식품이 다 소비되지 못해 음식물쓰레기가 되면 메탄을 배출하면서 또 한번 지구온난화에 기여하게 되는 거죠.
                                                    
                                                    유엔식량농업기구(FAO)는 식품의 생산과 소비 과정에서 발생하는 폐기물이 발생시키는 온실가스만해도, 전 세계 온실가스 배출량의 8~10%를 차지한다고 지적합니다. 무시할 수 없는 수준이죠?
                                                    
                                                    특히 음식물쓰레기 부패 과정에서 발생하는 메탄은 대기 중에 열을 가두는 효과가 이산화탄소의 80배나 돼, 지구온난화에 큰 영향을 미칩니다. 메탄 발생을 줄이게 되면 그만큼 큰 효과를 볼 수 있게 되는 거죠. 미국 환경보호국(EPA)은 ‘미국이 2015년에 땅에 묻은 음식물쓰레기를 절반으로 줄였다면 2020년에 1500만 가구에 1년간 전력을 공급할 수 있는 양 만큼 온실가스 배출량을 줄일 수 있었을 것’이라고 추산한 바 있습니다.
                                                    
                                                    미국해양대기청(NOAA)이 지난 4월 발표한 자료를 보면, 메탄은 해마다 증가해 산업화 이전보다 2.5배 이상 늘었다고 합니다. 세계가 메탄 감축에 마음이 바쁜 까닭입니다. 각국이 국가온실가스감축목표(NDC)에 음식물쓰레기 감축 방안을 포함시켜야 한다는 지적도 나옵니다. 하지만 한국을 포함해 대부분의 나라들은 음식물의 손실과 낭비를 구체적으로 얼마만큼 줄이겠다고 공식적으로 약속하지 않고 있습니다.
                                                    
                                                    일부에서는 국가적 실천 방안이 마련되기에 앞서, 미약하지만 개인적 실천을 제안하기도 합니다. 국제환경단체 세계자연기금(WWF)은 ‘온실가스 배출을 억제하기 위한 작은 조치를 시작하는 데 도움이 되는 몇 가지 팁’을 제시합니다. △공복에 장보지 않기 △식료품 구매 목록을 미리 계획해 필요한 것만 구입하기 △시들거나 갈변한 것, 흠집난 농산물 등을 이용해 잼·소스 만들기, 육수 내기에 활용하기 △식품이 상하기 전 냉동고에 보관하기 등입니다. 생각보다 쉽죠? 당장 오늘 저녁, 새로운 찬거리를 사기 위해 마트로 직행하는 대신 ‘냉장고 털기’부터 해보는 게 어떨까요.
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li>
                            <article class="article">
                                <div class="article-media">
                                    <a href="https://www.hani.co.kr/arti/society/society_general/1037865.html" target="_blank">
                                        <div class="article-2-image"></div>
                                    </a>
                                </div>
                                <div class="article-text">
                                    <div class="article-title-box-cover">
                                        <div class="article-title-box">
                                            <a href="https://www.hani.co.kr/arti/society/society_general/1037865.html" target="_blank">
                                                <h3 class="article-title black-han-sans-regular  rgb202020">&#34;음료수 하나로 한끼 버텨요&#34;&#46;&#46;&#46;<br>치솟는 물가에 취약계층 비명</h3>
                                            </a>
                                        </div>
                                        <div class="article-title-box-border">
                                            <h3 class="please-please black-han-sans-regular">왜<br>안 돼</h3>
                                            <div class="special-border-please"></div>
                                        </div>
                                    </div>
                                    <div class="margin-20-box">
                                        <div class="margin-20"><div class="special-border-please-2"></div></div>
                                        <div class="margin-20-border"></div>
                                    </div>
                                    <div class="article-content-box">
                                        <div class="date-and-margin-border">
                                            <div><p class="article-date nanum-gothic-regular rgb202020">2022.04.07</p></div>
                                            <div><p class="article-sources nanum-gothic-regular rgb202020">한겨레<span class="sortation"> | </span>김윤주,박지영,고병찬기자<span class="gap">공</span></p></div>
                                        </div>
                                        <a href="https://www.hani.co.kr/arti/society/society_general/1037865.html" target="_blank">
                                            <div class="article-content">
                                                <p class="article-content-summary nanum-gothic-regular rgb202020">
                                                    &emsp;“요즘 다 비싸서 아침에 음료수 하나로 버틸 때도 있어요. 물가가 오르는 걸 어떡하나요. 우리 같은 사람들은 지켜볼 수밖에...”
    
                                                    6일 낮 서울 중구 서울역 무료급식소 따스한채움터 인근 공터에는 노숙인과 노인 수백명이 줄지어 서 있었다. 교회에서 나눠주는 무료 간식을 받기 위해서다. 이른 아침부터 서울역에 나와 무료 급식으로 끼니를 때운 뒤 간식 나눔을 기다리던 조아무개(77)씨는 물가 얘기에 한숨을 쉬었다. “전엔 한 달에 한 번 정도 식당에 갈 때도 있었는데 요즘은 못 사 먹죠. 대부분 무료급식소에서 먹어요.” 같은 줄에 선 김아무개(69)씨도 “요즘 물가가 올라서 장 볼 때 너무 힘들다. 몸이 안 좋은 환자인데, 간식이라도 받아 챙겨가려고 나왔다”고 말했다. 정아무개(70)씨도 “무 하나에 3~4000원 하는데 어떻게 버티겠나”라고 토로했다. 이날 낮 12시30분께 봉사자들이 바나나, 김밥, 라면, 음료수 등이 든 꾸러미를 나눠주기 시작한 지 10분 만에 250여개가 모두 동났다.
                                                    
                                                    지난달 소비자물가가 10년 3개월 만에 최대폭인 전년 동월 대비 4.1% 상승하면서 시민들의 시름이 깊어 지고 있다. 특히 가공식품(6.4%), 외식 물가(6.6%) 등이 전년 동월 대비 크게 오르면서 취약계층은 ‘먹고사는 문제’의 어려움을 호소한다.
                                                    
                                                    이날 서울의 한 푸드뱅크에도 식료품을 구하려는 발길이 이어졌다. 푸드뱅크는 한 부모 가정, 기초생활수급자 등 지자체 복지망에 편입된 취약계층에게 식료품을 무료로 제공하는 공간이다. 이곳을 찾은 기초생활수급자 황아무개(65)씨는 “실질적으로 쓸 수 있는 생활비는 한달에 40만원 정도인데, 지난해부터 물가가 오르기 시작하더니 올해 폭등해 시장에 가면 아무것도 살 수 없다”며 “그나마 소 잡뼈는 싸니까 그걸 사서 푹 고아 밥을 먹는데 그것뿐이다. 야채나 과일은 꿈도 못 꾼다”고 말했다. 김아무개(65)씨도 “노령연금 48만원 정도 받고 사는데 물가가 너무 올라 시금치도 못 사 먹는다. 오늘 점심에도 우유 한 잔 먹고 나왔다”고 말했다.
                                                    
                                                    취약계층에게 식사를 제공하는 단체들도 부쩍 늘어난 식재료비에 부담을 느낀다. 서울 종로구 탑골공원 옆 ‘원각사 무료급식소’의 고영배 사무국장은 “식재료비가 월 1800만원에서 2000만원 정도로 11%가량 늘었다”며 “가스비에 전기세까지 오른 데다 코로나와 물가 상승으로 후원도 줄었다”고 말했다. 청량리역 일대에서 무료급식사업 밥퍼나눔운동을 운영하는 다일공동체의 박종범 대외협력실장은 “한 끼에 배식비가 3500원에서 최근 물가 상승과 코로나로 인한 도시락 용기 비용 등으로 1000원 이상 상승했는데, 금액이 누적되다 보니 부담”이라고 말했다. 경기도의 한 지역아동센터 관계자는 “가공식품, 채소, 과일, 쌀값이 올라 매일 아침 장 볼 때마다 당황스럽다. 한정된 예산에 맞추려면 과일을 넣는 횟수를 줄이거나 국산을 수입산으로 대체하는 등 아이들 급식 질이 떨어질 수밖에 없다”고 했다. 종로구에서 무료급식사업을 하는 사단법인 다나의 탄경 스님도 “물가가 올라 스님들과 봉사자들이 물건 살 때 몇 시간씩 인터넷을 뒤지면서 ‘최저가 찾기’에 열 올리고 있다”고 말했다.
                                                    
                                                    학생이나 취약계층이 주로 찾는 식당 등도 가격을 올리고 있다. 서울 관악구 신림동에서 6년째 고시식당을 운영하는 유아무개(62)씨는 “최근 한 끼에 500원, 열끼짜리 식권은 한 끼에 300원씩 올렸다”며 “물가 상승이 극심해 버티다 버티다 가격을 올렸는데, 올해는 더 올라 적자”라고 말했다. 관악구에서 8년째 중국집을 운영하는 김아무개 (63)씨는 “밀가루와 식용유 등이 너무 올라 부담이 크다. 싼 가격 때문에 오는 식당이라 가격 올리기가 부담돼 일단 두고 보는 중이다”라고 말했다. 대학 학생식당 밥값도 올랐다. 서울대에 재학 중인 수험생 이아무개(25)씨는 “학교나 고시식당에서 주로 점심을 해결하는데 최근 물가가 오른 걸 체감한다. 학식은 4000원이었던 메뉴가 6000원까지 오르는 등 쉽게 사 먹던 학식까지 고민하면서 선택해야 하는 상황이 됐다”고 말했다.
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </li>
                        <li>
                            <article class="article article-last">
                                <div class="article-media">
                                    <a href="https://www.joongang.co.kr/article/25041150" target="_blank">
                                        <div class="article-3-image"></div>
                                    </a>
                                </div>
                                <div class="article-text">
                                    <div class="article-title-box-cover">
                                        <div class="article-title-box">
                                            <a href="https://www.joongang.co.kr/article/25041150" target="_blank">
                                                <h3 class="article-title black-han-sans-regular  rgb202020">하루 음식쓰레기 2만t 비밀<br>4분의 1은 먹기도 전에 버려진다</h3>
                                            </a>
                                        </div>
                                        <div class="article-title-box-border">
                                            <h3 class="please-please black-han-sans-regular">왜<br>안 돼</h3>
                                            <div class="special-border-please"></div>
                                        </div>
                                    </div>
                                    <div class="margin-20-box">
                                        <div class="margin-20"><div class="special-border-please-2"></div></div>
                                        <div class="margin-20-border"></div>
                                    </div>
                                    <div class="article-content-box">
                                        <div class="date-and-margin-border">
                                            <div><p class="article-date nanum-gothic-regular rgb202020">2022.01.17</p></div>
                                            <div><p class="article-sources nanum-gothic-regular rgb202020">중앙일보<span class="sortation"> | </span>정종훈, 편광현, 장윤서 기자<span class="gap">공</span></p></div>
                                        </div>
                                        <a href="https://www.joongang.co.kr/article/25041150" target="_blank">
                                            <div class="article-content">
                                                <p class="article-content-summary nanum-gothic-regular rgb202020">
                                                    &emsp;12일 서울 서대문구의 한 마트. 생선·정육 등 신선식품 코너에 있는 주방 한편에 200ℓ짜리 음식물 처리기가 있었다. 직원들은 수시로 뚜껑을 열고 음식 쓰레기를 집어넣었다. 처리기에 들어간 음식 쓰레기는 건조·분해돼 액체 형태로 하수도로 빠져나간다. 마트 관계자는 "쓰레기가 계속 나오다 보니 기계를 24시간 돌려도 꽉 차곤 한다"고 말했다.
                                                    육류 등을 가공하면서 나오는 쓰레기 뿐 아니라 당일 판매 원칙인 야채나 생선도 팔리지 않으면 버려진다. 하지만 하루에 버려지는 양이 얼마나 되는지는 알 수 없다. 마트 관계자는 "배출량이 얼마인지 정확히 모른다. 포장용 플라스틱은 재활용하지만, 솔직히 음식 쓰레기를 줄이려는 생각은 하지 못하고 있다"고 했다.
                                                    버려지는 음식이 무방비로 쏟아지고 있다. 세계식량기구(FAO)는 매년 전 세계에서 생산하는 9400억 달러(약 1120조원)의 식품 중 30% 이상이 낭비된다고 추정한다. 버리는 음식만 줄여도 수억명이 배고픔을 면할 수 있다는 얘기다. 음식 쓰레기는 기후 위기와도 직결된다. 음식 쓰레기를 수거·재활용할 때 배출되는 온실가스가 엄청나기 때문이다.
                                                 
                                                    모든 국민이 매일 400g '음쓰' 버리는 셈 
                                                    국내에서 하루 배출되는 식품 관련 쓰레기는 2만t이 넘는다. 올림픽 수영장(2500㎥) 8개를 가득 채울 수 있는 양이다. 하지만 음식 쓰레기 문제는 10여년 전 종량제 배출 제도가 안착한 이후 별다른 관심을 받지 못했다. 탄소중립이나 플라스틱 등 다른 환경 이슈에 주목하는 동안 음식 쓰레기는 조용히 늘고 있다.
                                                    
                                                    국회입법조사처가 지난해 공개한 식품 손실 관련 보고서에 따르면 종량제 봉투 혼합배출·분리배출·동식물성 잔재물을 모두 합친 식품 폐기물 전체 발생량은 2017년 1만9106t에서 2019년 2만1065t으로 증가했다. 2013년(1만6032t)과 비교하면 6년 만에 약 31% 늘었다. 1인당 식품 폐기물 발생량(2019년)도 하루 407g에 달한다. 모든 국민이 날마다 삼겹살 2~3인분을 버리는 셈이다.
                                                    
                                                    특히 국내 음식 쓰레기의 4분의 1은 먹기도 전에 버려진다. 가정·식당 등의 음식 쓰레기는 2016년 1만4669t에서 2019년 1만4548t으로 내려갔다. 하지만 제조·생산에 따른 사업장 폐기물 수치는 같은 기간 계속 올랐다. 법적 정의가 모호한 식품 제조업발(發) 동식물성 잔재물도 2017년 3203t에서 2019년 5066t으로 급증했다. 전체 음식 쓰레기(2만1065t)의 4분의 1에 가까운 수치다.
                                                    
                                                    연구를 진행한 주문솔 한국환경연구원 부연구위원은 "우리나라는 소비자보다 산업계에서 음식 쓰레기를 줄이는 노력이 약한데다 각 사업장에서 발생한 폐기물이 적절히 처리됐는지도 불명확하다"고 지적했다.
                                                    
                                                    간편식, 가공식품 증가에 업체發 '음쓰' 급증
                                                    전문가들은 사업장에서의 음식 쓰레기 급증이 국민 식생활의 변화에 따른 것이라고 진단한다. 주문솔 부연구위원은 "식품 제조 과정에서의 발생량이 늘어난 것은 배달 음식과 가공식품, 간편식 소비 증가 같은 식생활 패턴 변화가 영향을 미쳤다. 앞으로 이러한 폐기물이 꾸준히 늘어날 확률이 높다"고 밝혔다.
                                                    
                                                    더 큰 문제는 식품이 만들어지고 팔리는 중에 어디서, 얼마나, 어떻게 폐기되는지 정확한 통계가 없다는 것이다. 아파트나 주택가 등은 공공 수거·재활용이 이뤄지지만, 대형 사업장들은 대부분 별도 계약을 맺은 민간 업체에 모든 처리를 맡겨서다. 그렇다 보니 음식 쓰레기 자체에 큰 관심이 없는 경우가 많다.
                                                    
                                                    취재팀이 주요 식품 유통·제조 업체 11곳에 문의한 결과, 음식 쓰레기 관련 수치를 파악하거나 감량 대책을 세운 곳은 거의 없었다. 한 식품 업체 관계자는 "폐기 업체에 맡기고 있어 정확히 파악한 바가 없다"라고 했다. 식품 체인 업체 관계자는 "멀쩡한 음식이 많이 남지만 딱히 쓸 방법이 없다. 음식 쓰레기 줄이려는 노력은 하지만 통계를 챙기진 않는다"고 했다.
                                                    
                                                    세부 통계 불명확…'업사이클링' 정책 세워야
                                                    이를 관리해야 할 정부도 막막하긴 마찬가지다. 음식 쓰레기의 기초 자료인 '전국 폐기물 발생 및 처리 현황' 통계도 시군구 단위로 폐기물 분류, 처리 방식 정도만 공개한다. 경로 추적이 안 되다 보니 어떤 부산물이 주로 나오는지, 이 중에서 쓸 수 있는 건 뭔지 알기가 어렵다. 환경부 관계자는 "대개 동식물성 잔재물 등은 필요한 업체가 알아서 챙겨간 뒤 처리하는 식이다. 실제 재활용하거나 처리한 양 등을 알아야 하는데 사업장에서 별도 신고를 하지 않으면 파악하기 쉽지 않다"라고 말했다.
                                                    
                                                    그나마 일부 기업들이 그냥 버려지는 식품 부산물을 챙기고 재활용하는 데 관심을 갖기 시작했다. 한 가공 업체 관계자는 "쌀겨, 콩비지 같은 부산물이 많이 나와서 또 다른 식품 등에 활용하려고 준비 중"이라고 밝혔다.
                                                    
                                                    홍수열 자원순환사회경제연구소장은 "우리나라는 식품을 최대한 이용할 수 있는 업사이클링 관점이 전혀 없다. 단순한 음식 쓰레기가 아닌 식량 자원으로 봐야 한다"라면서 "남는 식품을 그냥 버리지 않고 순환하는 정책을 추진하는 한편, 기업도 거기에 맞춰 달라져야 한다"라고 강조했다. 허승은 녹색연합 녹색사회팀장도 "산업계에서 발생하는 식품 폐기량에 대한 정확한 통계부터 마련하는 게 급선무다. 이를 바탕으로 음식 쓰레기 감량 계획을 새로 세워야 한다"라고 밝혔다.
                                                </p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </li>
                    </ul>
                </section>
                <div class="margin200"></div>
            </main>
            <footer>
                <div>
                    <div>
                        <ul class="footer-boxes">
                            <li>
                                <ul class="footer-box-1">
                                    <li><a href="https://www.youtube.com/"><img src="images/icon-youtube.png" alt="유튜브 이동"></a></li>
                                    <p>|</p>
                                    <li><a href="https://www.instagram.com/"><img src="images/icon-instagram.png" alt="인스타그램 이동"></a></li>
                                </ul>
                            </li>
                            <li>
                                <ul class="footer-box-2">
                                    <li class="nanum-gothic-regular"><span class="footer-box-2-item-name">프로젝트명:</span>SOSEGE</li>
                                    <li class="nanum-gothic-regular"><span class="footer-box-2-item-name">팀명:</span>소새지</li>
                                    <li>
                                        <ul>
                                            <li class="nanum-gothic-regular"><span class="footer-box-2-item-name">팀장:</span>팀장_이름</li>
                                            <p class="nanum-gothic-regular">|</p>
                                            <li class="nanum-gothic-regular"><span class="footer-box-2-item-name">이메일주소:</span>팀장_이메일</li>
                                        </ul>
                                    </li>
                                    <li class="nanum-gothic-regular"><span class="footer-box-2-item-name">팀원:</span>팀원들</li>
                                </ul>
                            </li>
                            <li>
                                <ul class="footer-box-3">
                                    <a href="#"><li class="nanum-gothic-regular">개인정보처리방침</li></a>
                                    <p class="nanum-gothic-regular">|</p>
                                    <a href="#"><li class="nanum-gothic-regular">이용약관</li></a>
                                    <p class="nanum-gothic-regular">|</p>
                                    <a href="#"><li class="nanum-gothic-regular">운영정책</li></a>
                                    <p class="nanum-gothic-regular">|</p>
                                    <a href="#"><li class="nanum-gothic-regular">팀소개</li></a>
                                    <p class="nanum-gothic-regular">|</p>
                                    <a href="#"><li class="nanum-gothic-regular">문의하기</li></a>
                                    <p class="nanum-gothic-regular">|</p>
                                    <a href="#"><li class="nanum-gothic-regular">광고문의</li></a>
                                </ul>
                            </li>
                            <li class="copyright nanum-gothic-regular">&copy; 2025 SOSEGE. All rights reserved.</li>
                        </ul>
                    </div>
                    <img src="images/logo_black.png" alt="소새지 블랙 로고" class="footer-black-logo">
                </div>
            </footer>
        </div>
        <script src="script.js?v=1.1"></script>
    </body>
</html>
