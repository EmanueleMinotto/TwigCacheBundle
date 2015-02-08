# Get ApiGen.phar
wget http://www.apigen.org/apigen.phar

# Generate Api
php apigen.phar generate -s . --exclude=vendor --exclude=Tests -d ../gh-pages --todo --tree --no-source-code
cd ../gh-pages

# Set identity
git config --global user.email "travis@travis-ci.org"
git config --global user.name "Travis"

# Add branch
git init
git remote add origin https://${GH_TOKEN}@github.com/EmanueleMinotto/TwigCacheBundle.git > /dev/null
git checkout -B gh-pages
git rm -rf .

# Push generated files
git add --all .
git commit -m "API updated"
git push origin gh-pages -fq > /dev/null