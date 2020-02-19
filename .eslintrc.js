module.exports = {
    root: true,
    env: {
        node: true
    },
    'extends': [
        'plugin:vue/essential',
        '@vue/standard'
    ],
    rules: {
        'no-console': 'off',
        'no-debugger': 'off',
        'indent': 'off',
        'space-before-function-paren': 0,
        'eol-last': 0
    },
    parserOptions: {
        parser: 'babel-eslint'
    }
}
