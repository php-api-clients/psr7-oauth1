all:
	composer qa-all

ci:
	composer qa-ci

contrib:
	composer qa-contrib

init:
	composer ensure-installed

cs:
	composer cs

unit:
	composer unit

mutation:
	composer mutation

ci-coverage: init
	composer ci-coverage
