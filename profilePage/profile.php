<?php
session_set_cookie_params([
    'path' => '/',
    'httponly' => true,
    'secure' => false, 
    'samesite' => 'Lax'
]);

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../sign_up/signUp.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SOSEGE</title>
  <link rel="stylesheet" href="profile_style.css?v=1.2">
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
              <a href="../listPage/listPage2.php"><li class="nanum-gothic-regular">추천</li></a>
              <a href="../writePage/write.php"><li class="nanum-gothic-regular">글쓰기</li></a>
              <a href="#"><li class="nanum-gothic-regular">이벤트</li></a>
              <a href="#"><li class="nanum-gothic-regular">고객센터</li></a>
              <a href="../sign_up/signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>


              <a href="profile.php"><li class="nanum-gothic-regular">프로필</li></a>
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
              <a href="profile.php" class="profile-button"><div></div></a>
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
              <a href="../listPage/listPage2.php"><li class="nanum-gothic-regular">추천</li></a>
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
                  <a href="profile.php"><li class="nanum-gothic-regular">프로필</li></a>
                  <p class="nanum-gothic-regular">|</p>
              <?php endif; ?>
          </ul>



      </div>
  </nav>
  <div class="main-footer">
    <main class="main">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-image">
                    <img src="user.png" alt="프로필 사진">
                </div>
                <p class="nanum-gothic-regular user-name" id="id">이름</p>
                <p class="nanum-gothic-regular email-address" id="email">your.email@example.com</p>
            </div>

            <div class="profile-stats">
                <div class="stat-item">
                    <p class="subscription-date nanum-gothic-regular">가입일</p>
                    <p class="nanum-gothic-regular subscription-date-date" id="join-date">25.05.05</p>
                </div>
                <div class="stat-item" id="corporate-auth-section">
                    <img src="tick-mark.png" alt="완료 표시" class="stat-icon">
                </div>
            </div>

            <button class="logout-button noto-sans-kr-700">로그아웃</button>
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
  <script src="profile_script.js?v=1.2"></script>
</body>
</html>