---
description: 將專案遷移至 CodeIgniter 4 並使用 Docker Compose
---

# Bonus Shoes 專案遷移至 CodeIgniter 4 實施計劃

## 一、專案現況評估

### 1.1 現有架構分析

**專案類型**: 傳統 PHP 專案（無框架）

**技術棧**:
- **後端**: 原生 PHP + 自製 PDO 封裝類別
- **前端**: HTML + Tailwind CSS + jQuery + ES6 模組
- **資料庫**: MySQL (遠端連線)
- **建置工具**: npm (僅用於 Tailwind CSS 編譯)

**目錄結構**:
```
bonus.shoes/
├── __Class/              # 核心類別庫
│   ├── ClassLoad.php     # 自動載入與初始化
│   ├── Works.php         # 業務邏輯類別
│   └── pdo.php          # PDO 封裝類別 (569行)
├── Pages/               # 頁面與 AJAX 處理
│   ├── ajax/
│   │   └── index.php    # API 端點
│   └── js/
│       ├── index.js     # 前端邏輯
│       └── ajax.js      # AJAX 請求封裝
├── config/              # 配置文件
│   └── config.php       # 資料庫配置（硬編碼）
├── dist/                # Tailwind 編譯輸出
├── src/                 # Tailwind 源碼
├── index.php            # 主頁面
└── package.json         # npm 配置
```

**核心功能**:
1. 顯示鞋子商品資料表格
2. AJAX 方式取得資料庫資料
3. 根據 action 欄位顯示不同顏色（新增/更新/刪除）
4. Session 管理

**資料庫連線**:
- Host: 139.162.15.125:9907
- Database: bonus-shoes
- Table: shoes_show_inf

### 1.2 現有問題

1. **安全性問題**:
   - 資料庫帳密硬編碼在 config.php
   - 無環境變數管理
   - 無 CSRF 保護
   - SQL 注入風險（雖有 PDO，但自製封裝可能有漏洞）

2. **架構問題**:
   - 無 MVC 架構
   - 業務邏輯與展示層混合
   - 無路由系統
   - 無依賴注入

3. **維護性問題**:
   - 無標準化框架
   - 自製 PDO 類別過於複雜（569行）
   - 無 API 版本控制
   - 無錯誤處理機制

4. **部署問題**:
   - 無容器化
   - 環境依賴不明確
   - 無自動化部署

---

## 二、CodeIgniter 4 遷移方案

### 2.1 遷移優勢

1. **標準化 MVC 架構**: 清晰的程式碼組織
2. **內建 ORM (Model)**: 取代自製 PDO 類別
3. **RESTful API 支援**: 標準化 API 設計
4. **環境變數管理**: .env 配置
5. **安全性增強**: CSRF、XSS 保護
6. **CLI 工具**: 快速生成程式碼
7. **現代化 PHP**: 支援 PHP 8.x

### 2.2 新架構設計

```
ci4-bonus-shoes/
├── docker/
│   ├── php/
│   │   └── Dockerfile
│   ├── nginx/
│   │   └── default.conf
│   └── mysql/
│       └── init.sql
├── docker-compose.yml
├── .env                    # 環境變數
├── .env.example           # 環境變數範本
├── app/
│   ├── Config/
│   │   └── Routes.php     # 路由配置
│   ├── Controllers/
│   │   └── Api/
│   │       └── ShoesController.php
│   ├── Models/
│   │   └── ShoesModel.php
│   ├── Views/
│   │   └── shoes/
│   │       └── index.php
│   └── Database/
│       └── Migrations/
│           └── 2026-01-07-create_shoes_table.php
├── public/
│   ├── index.php
│   ├── assets/
│   │   ├── css/
│   │   └── js/
│   └── dist/              # Tailwind 輸出
├── writable/
└── vendor/
```

---

## 三、Docker Compose 環境設計

### 3.1 服務架構

```yaml
services:
  nginx:      # Web 伺服器
  php-fpm:    # PHP 應用
  mysql:      # 資料庫
  phpmyadmin: # 資料庫管理
```

### 3.2 Port 管理策略

所有對外 Port 統一由 `.env` 管理：

```env
# 應用配置
APP_PORT=8080           # Nginx 對外 Port
PHPMYADMIN_PORT=8081    # phpMyAdmin Port

# 資料庫配置
MYSQL_PORT=3306         # MySQL 對外 Port
MYSQL_ROOT_PASSWORD=root_password
MYSQL_DATABASE=bonus_shoes
MYSQL_USER=bonus_user
MYSQL_PASSWORD=bonus_password

# CodeIgniter 配置
CI_ENVIRONMENT=development
app.baseURL=http://localhost:8080
```

### 3.3 資料遷移策略

**選項 A: 使用現有遠端資料庫**
- 優點: 無需資料遷移
- 缺點: 開發環境依賴遠端

**選項 B: 建立本地資料庫**（建議）
- 使用 mysqldump 匯出遠端資料
- 透過 Docker init.sql 初始化
- 開發與生產環境分離

---

## 四、實施步驟

### 階段一: 環境建置（預估 2-3 小時）

1. **建立 Docker 環境**
   - 撰寫 Dockerfile (PHP-FPM + Nginx)
   - 撰寫 docker-compose.yml
   - 配置 .env 檔案
   - 測試容器啟動

2. **安裝 CodeIgniter 4**
   - 使用 Composer 安裝
   - 配置基本設定
   - 測試首頁顯示

3. **建立資料庫**
   - 設計 Migration
   - 匯入現有資料（如需要）
   - 測試連線

### 階段二: 核心功能遷移（預估 4-5 小時）

1. **建立 Model**
   - ShoesModel: 對應 shoes_show_inf 表
   - 使用 CI4 Query Builder 取代自製 PDO

2. **建立 Controller**
   - ShoesController: 處理 AJAX 請求
   - 實作 RESTful API

3. **建立 View**
   - 遷移 index.php 頁面
   - 整合 Tailwind CSS
   - 調整 AJAX 請求路徑

4. **路由配置**
   - 設定 API 路由
   - 設定頁面路由

### 階段三: 功能增強（預估 2-3 小時）

1. **安全性強化**
   - 啟用 CSRF 保護
   - 輸入驗證
   - XSS 過濾

2. **錯誤處理**
   - 統一錯誤回應格式
   - 日誌記錄

3. **Session 管理**
   - 遷移 BaseWork::start_session()
   - 使用 CI4 Session Library

### 階段四: 測試與優化（預估 2 小時）

1. **功能測試**
   - 資料顯示測試
   - API 測試
   - 前端互動測試

2. **效能優化**
   - 查詢優化
   - 快取設定

3. **文件撰寫**
   - README.md
   - 部署文件
   - API 文件

---

## 五、風險評估與對策

### 5.1 技術風險

| 風險 | 影響 | 對策 |
|------|------|------|
| 自製 PDO 類別功能複雜 | 高 | 逐步遷移，保留舊程式碼作為參考 |
| 前端 jQuery 相依性 | 中 | 保持 jQuery，未來再考慮遷移 |
| 遠端資料庫連線問題 | 中 | 建立本地開發資料庫 |
| Docker 環境相容性 | 低 | 使用官方映像檔 |

### 5.2 時程風險

- **預估總時數**: 10-13 小時
- **建議分配**: 2-3 個工作天
- **緩衝時間**: 額外保留 20% 時間處理未預期問題

---

## 六、遷移後優勢

### 6.1 開發效率提升

- ✅ 標準化框架，降低學習成本
- ✅ CLI 工具快速生成程式碼
- ✅ 內建驗證與安全機制
- ✅ 完整的文件支援

### 6.2 維護性提升

- ✅ MVC 架構清晰
- ✅ 程式碼重用性高
- ✅ 易於單元測試
- ✅ 社群支援完善

### 6.3 部署便利性

- ✅ Docker 容器化
- ✅ 環境一致性
- ✅ 快速部署
- ✅ 易於擴展

### 6.4 安全性提升

- ✅ 框架級別安全防護
- ✅ 環境變數管理敏感資訊
- ✅ 定期安全更新
- ✅ 最佳實踐內建

---

## 七、後續建議

### 7.1 短期目標（1-2 週）

1. 完成基本功能遷移
2. 建立完整的 Docker 開發環境
3. 撰寫基本文件

### 7.2 中期目標（1-2 個月）

1. 新增完整的 CRUD 功能
2. 實作使用者權限管理
3. 建立自動化測試
4. 前端改用 Vue.js 或 React（選擇性）

### 7.3 長期目標（3-6 個月）

1. 微服務架構拆分
2. 引入 Redis 快取
3. 實作 CI/CD 流程
4. 效能監控與優化

---

## 八、決策建議

### 建議採用方案

**✅ 完整遷移至 CodeIgniter 4 + Docker Compose**

**理由**:
1. 現有專案規模小，遷移成本可控
2. 長期維護成本大幅降低
3. 符合現代化開發標準
4. 易於團隊協作

**不建議方案**:
- ❌ 僅 Docker 化現有程式碼：治標不治本
- ❌ 部分遷移：增加維護複雜度
- ❌ 使用其他框架（Laravel）：學習成本較高

---

## 九、立即行動項目

如果您同意此方案，我將立即執行以下步驟：

1. ✅ 建立 Docker Compose 環境配置
2. ✅ 安裝 CodeIgniter 4
3. ✅ 建立資料庫 Migration
4. ✅ 遷移核心功能
5. ✅ 測試與驗證

**預計完成時間**: 今日可完成階段一與階段二

---

## 十、需要確認的問題

在開始實施前，請確認：

1. **資料庫策略**: 使用遠端資料庫 or 建立本地資料庫？
2. **Port 配置**: 預設 8080 (App) / 8081 (phpMyAdmin) / 3306 (MySQL) 是否可接受？
3. **PHP 版本**: 建議使用 PHP 8.1，是否同意？
4. **資料遷移**: 是否需要從遠端資料庫匯出資料？
5. **舊程式碼**: 遷移完成後是否保留舊程式碼作為備份？

請回覆您的決定，我將立即開始實施！
