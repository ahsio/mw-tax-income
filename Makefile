.PHONY: build install test

build: install

install:
	composer run-script build

test:
	./bin/phpspec run -fpretty
