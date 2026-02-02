# Bonus Shoes - 一鍵啟動指南

## 快速啟動

只需執行一個命令即可啟動整個專案：

```bash
docker compose up -d --build
```

## 就是這樣！

容器會自動：
- ✅ 等待 MySQL 完全啟動
- ✅ 自動安裝 Composer 依賴
- ✅ 創建並設置 writable 目錄權限
- ✅ 清理應用緩存
- ✅ 啟動所有服務

## 訪問應用

- **應用程式**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

## 停止專案

```bash
docker compose down
```

## 完全重置（清除所有資料）

```bash
docker compose down -v
docker compose up -d --build
```

## 查看日誌

```bash
# 查看所有容器日誌
docker compose logs -f

# 只查看 PHP 容器日誌
docker compose logs -f php

# 只查看 Nginx 容器日誌
docker compose logs -f nginx
```

## 故障排除

### 如果遇到問題

1. 停止所有容器：
   ```bash
   docker compose down
   ```

2. 清理並重新啟動：
   ```bash
   docker compose up -d --build
   ```

3. 查看日誌找出問題：
   ```bash
   docker compose logs -f
   ```

## 配置說明

所有配置都在 `.env` 文件中，包括：
- 應用端口 (APP_PORT)
- 資料庫設定
- phpMyAdmin 端口

修改 `.env` 後需要重啟容器：
```bash
docker compose restart
```
