<?php
session_start();
?>

<!DOCTYPE html>
<html lang="ko">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SOSEGE</title>
  <link rel="stylesheet" href="signUp.css?v=1.4">
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
              <a href="signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>


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
              <a href="signUp.php" class="signIn-button"><p class="nanum-gothic-regular">로그인</p></a>
              <p class="nanum-gothic-regular">|</p>
              <a href="signUp.php" class="signUp-button"><p class="nanum-gothic-regular">회원가입</p></a>
          <?php endif; ?>
          
          
          <p class="nanum-gothic-regular">|</p>


          <?php if (isset($_SESSION['user_id'])): ?>
              <a href="../profilePage/profile.php" class="profile-button"><div></div></a>
          <?php else: ?>
              <a href="signUp.php" onclick="alert('로그인이 필요합니다.');" class="profile-button"><div></div></a>
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
                  <a href="signUp.php" onclick="alert('로그인이 필요합니다.');">
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
                  <a href="signUp.php"><li class="nanum-gothic-regular">로그인·회원가입</li></a>
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
      <figure class="margin"></figure>
      <aside class="signUp" id="signUp">
        <section class="form">
          <h1 class="anton-regular sign-title">Sign Up</h1>
          <form method="post" class="join_membership" action="">
            <input type="text" id="phoneNumber" name="phoneNumber" pattern="\d{11}" title="하이폰을 빼고 입력해주세요" required placeholder="전화번호" autocomplete="off" class="sign-input inter-300">
            <input type="email" id="email" name="email" required title="이메일 형식으로 기입해주세요" placeholder="이메일" autocomplete="off" class="sign-input inter-300">
            <input type="text" id="ID1" name="id" required maxlength="10" placeholder="아이디" title="아이디를 입력해주세요" autocomplete="off" class="sign-input inter-300">
            <input type="password" id="password1" name="password" required maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*]).{8,}$" title="영문자, 숫자, 특수문자/기호를 각각 1개 이상 포함해야 합니다" placeholder="비밀번호" autocomplete="off" class="sign-input inter-300">
            <hr>
            <input type="checkbox" id="clause" name="clause" class="custom-checkbox">
            <label class="label" for="clause">약관 동의</label><br>
            <input type="checkbox" id="personalInformation" name="personalInformation" class="custom-checkbox">
            <label class="label" for="personalInformation">개인정보 수집 동의</label><br>
            <input type="submit" id="submit1" value="회원가입">
            <figure class="change"><input type="button" id="logInChange" value="로그인" name="logInChange"></figure>
          </form>
        </section>
        <section class="link">
          <a href="#">비밀번호 찾기</a>
          <a href="#">아이디 찾기</a>
        </section>
        <figure class="margin"></figure>
      </aside>
      <aside class="logIn hidden" id="logIn">
        <section class="form">
          <h1 class="anton-regular sign-title">Log In</h1>
          <form method="post" class="join_membership">
            <input type="text" id="ID2" name="id" required maxlength="10" placeholder="아이디" title="아이디를 입력해주세요" autocomplete="off" class="sign-input inter-300">
            <input type="password" id="password2" name="password" required maxlength="20" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[!@#$%^&*]).{8,}$" title="영문자, 숫자, 특수문자/기호를 각각 1개 이상 포함 및 8자리 이상이어야 합니다" placeholder="비밀번호" autocomplete="off" class="sign-input inter-300">
            <input type="submit" id="submit2" value="로그인">
            <figure class="change"><input type="button" id="signUpChange" value="회원가입" name="signUpChange"></figure>
          </form>
        </section>
        <section class="link">
          <a href="#">비밀번호 찾기</a>
          <a href="#">아이디 찾기</a>
        </section>
        <figure class="margin200"></figure>
      </aside>
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
  <script src="signUp.js?v=1.4"></script>
</body>
</html>