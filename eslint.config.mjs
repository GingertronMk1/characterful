import globals from "globals";
import pluginJs from "@eslint/js";
import tseslint from "typescript-eslint";

export default [
  pluginJs.configs.recommended,
  ...tseslint.configs.strict,
  ...tseslint.configs.stylistic,
  {
    files: ["./assets/**/*.{js,mjs,cjs,ts}"],
    languageOptions: {
      ecmaVersion: 2020,
      globals: {...globals.browser, ...globals.node},
      parserOptions: {
        ecmaVersion: 'latest',
        ecmaFeatures: { jsx: true },
        sourceType: 'module',
      },
    },
  },
  {
    ignores: [
      "**/node_modules/**",
      "**/public/**",
      "**/vendor/**",
    ]
  }
];