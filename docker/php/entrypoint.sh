#!/bin/sh
set -e

echo "🚀 Bonus Shoes - 容器初始化..."

# 等待 MySQL 就緒
echo "⏳ 等待 MySQL 連接..."
until nc -z -v -w30 mysql 3306
do
  echo "等待 MySQL 啟動... (5秒後重試)"
  sleep 5
done
echo "✅ MySQL 已就緒"

# 如果 vendor 目錄不存在，安裝依賴
if [ ! -d "/var/www/html/vendor" ] || [ ! -f "/var/www/html/vendor/autoload.php" ]; then
    echo "📦 首次啟動 - 安裝 Composer 依賴..."
    composer install --no-interaction --optimize-autoloader --no-dev 2>/dev/null || \
    composer install --no-interaction --optimize-autoloader || true
    echo "✅ Composer 依賴安裝完成"
else
    echo "✅ Composer 依賴已存在"
fi

# 確保 writable 目錄存在並設置權限
echo "🔐 設置 writable 目錄權限..."
mkdir -p /var/www/html/writable/cache \
         /var/www/html/writable/logs \
         /var/www/html/writable/session \
         /var/www/html/writable/uploads \
         /var/www/html/writable/debugbar

# 設置正確的所有權和權限
chown -R www-data:www-data /var/www/html/writable
chown -R www-data:www-data /var/www/html/vendor 2>/dev/null || true
chown www-data:www-data /var/www/html/composer.lock 2>/dev/null || true

# 設置完全寫入權限
chmod -R 777 /var/www/html/writable

echo "✅ 權限設置完成"

# 清理緩存
if [ -f "/var/www/html/spark" ]; then
    echo "🧹 清理應用緩存..."
    php /var/www/html/spark cache:clear 2>/dev/null || true
fi

echo "✨ 初始化完成！啟動 PHP-FPM..."

# 執行原始的 CMD
exec "$@"
