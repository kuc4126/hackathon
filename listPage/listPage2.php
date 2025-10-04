<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SOSEGE</title>
  <link rel="stylesheet" href="listPage_style2.css?v=1.5">
  <link rel="icon" href="images/favicon.png" type="image/x-icon">
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
              <a href="../searchPage/search.php"><li class="nanum-gothic-regular">검색</li></a>
              <a href="listPage2.php"><li class="nanum-gothic-regular">추천</li></a>
              <a href="../writePage/write.php"><li class="nanum-gothic-regular">글쓰기</li></a>
              <a href="#"><li class="nanum-gothic-regular">이벤트</li></a>
              <a href="#"><li class="nanum-gothic-regular">고객센터</li></a>
              <a href="../sign_up/signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>


              <a href="../profilePage/profile.php"><li class="nanum-gothic-regular">프로필</li></a>
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
              <a href="../sign_up/signUp.php" class="signIn-button"><p class="nanum-gothic-regular">로그인</p></a>
              <p class="nanum-gothic-regular">|</p>
              <a href="../sign_up/signUp.php" class="signUp-button"><p class="nanum-gothic-regular">회원가입</p></a>
          <?php endif; ?>
          
          
          <p class="nanum-gothic-regular">|</p>


          <?php if (isset($_SESSION['user_id'])): ?>
              <a href="../profilePage/profile.php" class="profile-button"><div></div></a>
          <?php else: ?>
              <a href="../sign_up/signUp.php" onclick="alert('로그인이 필요합니다.');" class="profile-button"><div></div></a>
          <?php endif; ?>
          <p class="nanum-gothic-regular">|</p>


      </div>
  </header>
  <nav>
      <div>
          <ul class="navigation-bar-default">
              <p class="nanum-gothic-regular">|</p>
              <a href="../searchPage/search.php"><li class="nanum-gothic-regular">검색</li></a>
              <p class="nanum-gothic-regular">|</p>
              <a href="listPage2.php"><li class="nanum-gothic-regular">추천</li></a>
              <p class="nanum-gothic-regular">|</p>
              <!-- <a href="/writePage/write.html"><li class="nanum-gothic-regular">글쓰기</li></a> -->
              
              <?php if (isset($_SESSION['user_id'])): ?>
                  <a href="../writePage/write.php">
                      <li class="nanum-gothic-regular">글쓰기</li>
                  </a>
              <?php else: ?>
                  <a href="../sign_up/signUp.php" onclick="alert('로그인이 필요합니다.');">
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
                  <a href="../sign_up/signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>
                  <p class="nanum-gothic-regular">|</p>
              <?php else: ?>
                  <a href="../profile/profile.php"><li class="nanum-gothic-regular">프로필</li></a>
                  <p class="nanum-gothic-regular">|</p>
              <?php endif; ?>
          </ul>



      </div>
  </nav>
  <div class="main-footer">
    <main class="main">
        <div class="list">
            <p class="listtext black-han-sans-regular">게시글</p>
            <div class="list2">
                <div class="container-container">
                    <label class="container container-1">최신순
                        <input type="radio" id="distance" checked="checked" name="radio">
                        <span class="checkmark"></span>
                    </label>
                    <label class="container container-2">가격순
                        <input type="radio" id="fast" name="radio">
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="low-high-price">
                    <div class="low-price price-price">낮은가격순</div>
                    <div class="high-price price-price">높은가격순</div>
                </div>
            </div>
        </div>

        <div id="post-container" class="post-container"></div>

        <div class="button">
            <ul class="page-number">
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
            </ul>
        </div>
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
  <script src="ListPage.js?v=1.5"></script>
</body>
</html>