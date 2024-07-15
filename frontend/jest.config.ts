// jest.config.js
module.exports = {
    testEnvironment: 'node',
    testMatch: [
      '**/tests/**/*.test.[jt]s', // padrão para arquivos de teste JavaScript e TypeScript
    ],
    transform: {
      '^.+\\.[tj]s$': 'ts-jest', // transforma arquivos TypeScript e JavaScript usando ts-jest
    },
    moduleNameMapper: {
      '^@/(.*)$': '<rootDir>/src/$1', 
    },
    moduleFileExtensions: ['js', 'ts'], 
  };
  