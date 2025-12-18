# 🎙️ S.E.R.A (Speech Emotion Recognition AI) - Web Platform

> **음성 감정 분석 AI 프로젝트 'S.E.R.A'의 웹 서비스 리포지토리입니다.** > PHP와 MySQL을 기반으로 구축되었으며, 시큐어 코딩(Secure Coding) 원칙을 준수하여 개발되었습니다.

<br>

## 📋 프로젝트 개요
**S.E.R.A Web**은 감정 분석 AI 서비스를 소개하고, 사용자가 시연 영상을 시청하거나 커뮤니티(게시판)를 통해 소통할 수 있는 웹 플랫폼입니다.  
단순한 정보 전달을 넘어 **회원가입, 로그인, 마이페이지, 게시판(파일 업로드 포함)** 등 웹의 핵심 기능을 모두 구현하였으며, 특히 **OWASP Top 10** 보안 취약점을 고려하여 안전한 웹 사이트를 구축하는 데 중점을 두었습니다.

<br>

## 🛠️ 기술 스택 (Tech Stack)
<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white"> <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white"> <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white"> <img src="https://img.shields.io/badge/Apache-D22128?style=for-the-badge&logo=apache&logoColor=white">

* **Backend:** PHP 8.0+ (Native)
* **Database:** MySQL (MariaDB)
* **Frontend:** HTML5, Tailwind CSS (CDN)
* **Server:** Apache (XAMPP Environment)

<br>

## 🔒 핵심 보안 기능 (Security Features)
본 프로젝트는 **보안(Security) 전공자**로서 다음과 같은 시큐어 코딩을 적용했습니다.

### 1. SQL Injection 방지
* 모든 데이터베이스 쿼리에 `Prepared Statement` (Pre-compilation)를 적용했습니다.
* 사용자 입력값을 `bind_param()`으로 처리하여 쿼리 조작을 원천 차단했습니다.

### 2. XSS (Cross Site Scripting) 방지
* 게시판 및 사용자 정보 출력 시 `htmlspecialchars()` 함수를 사용하여 스크립트 실행을 방지했습니다.

### 3. 안전한 비밀번호 저장 (Password Hashing)
* 비밀번호를 평문(Plain Text)으로 저장하지 않습니다.
* PHP 표준 `password_hash()` (Bcrypt 알고리즘)를 사용하여 단방향 암호화 후 DB에 저장합니다.
* 로그인 시 `password_verify()`를 통해 안전하게 검증합니다.

### 4. 파일 업로드 보안
* **확장자 검증:** 실행 파일(.php, .exe 등) 업로드를 막기 위해 허용된 이미지 확장자(jpg, png 등)만 업로드 가능하도록 화이트리스트 검사를 수행합니다.
* **파일명 난수화:** 업로드된 파일명을 `uniqid()`를 사용하여 랜덤한 문자열로 변경, 덮어쓰기 방지 및 파일명 추측 공격을 예방했습니다.

### 5. 세션 기반 인증 및 접근 제어
* 쿠키 대신 서버 사이드 **Session**을 사용하여 로그인 상태를 관리합니다.
* 비로그인 사용자가 마이페이지 등 특정 페이지에 접근할 수 없도록 페이지 상단에서 세션을 검증합니다.

<br>

## 📂 디렉토리 구조 (Directory Structure)
```bash
S.E.R.A_WEB/
├── index.php          # 메인 페이지 (로그인 상태에 따른 헤더 변화)
├── login.php          # 로그인 페이지
├── register.php       # 회원가입 페이지 (유효성 검사 포함)
├── mypage.php         # 마이페이지 (개인정보 관리, 구글 스타일 UI)
├── logout.php         # 로그아웃 처리
├── features.php       # 특징 소개 페이지 (POST 접근 제어 예시)
├── demo.php           # 시연 영상 페이지
├── playground.php     # 자유 게시판 (CRUD, 이미지 업로드)
├── uploads/           # 게시판 이미지 업로드 폴더
└── sera.png           # 메인 이미지 리소스

💾 데이터베이스 설계 (Database Schema)프로젝트 실행을 위해 아래 SQL문을 사용하여 테이블을 생성해야 합니다.1. 사용자 테이블 (users)SQLCREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    profile_img VARCHAR(255) DEFAULT NULL,
    gender VARCHAR(10) DEFAULT '미설정',
    phone VARCHAR(20) DEFAULT NULL,
    birthdate DATE DEFAULT NULL,
    address VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
2. 게시판 테이블 (playground_table)SQLCREATE TABLE IF NOT EXISTS playground_table (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    writer VARCHAR(50) NOT NULL,
    content TEXT NOT NULL,
    tag VARCHAR(20) DEFAULT '일반',
    views INT DEFAULT 0,
    file_name VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


