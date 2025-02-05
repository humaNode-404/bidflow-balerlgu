// resources/js/utils/validationRules.js
import dayjs from 'dayjs';
import relativeTime from 'dayjs/plugin/relativeTime';
dayjs.extend(relativeTime);

// Helper function for "Field is required" rule
export const requiredRule = (field = 'Field') => [
  (v) => !!v || `${field} is required`,
];

// Password Validation Rule
export const passwordRules = [
  ...requiredRule('Password'),
  (v) => v.length >= 8 || 'Password must be at least 8 characters long',
  (v) => /[A-Z]/.test(v) || 'Password must contain an uppercase letter',
  (v) => /[a-z]/.test(v) || 'Password must contain a lowercase letter',
  (v) => /\d/.test(v) || 'Password must contain a number',
  (v) =>
    /[!@#$%^&*(),.?":{}|<>]/.test(v) ||
    'Password must contain a special character',
];

// Email Validation Rule
export const emailRules = [
  ...requiredRule('Email'),
  (v) => /^\S+@\S+\.\S+$/.test(v) || 'Email must be valid',
];

// Name Validation Rule (letters only)
export const nameRules = [
  ...requiredRule('Name'),
  (v) => /^[A-Za-z\s]+$/.test(v) || 'Name must only contain letters and spaces',
];

// Character Count Validation Rule
export const characterCountRules = (min = 1, max = 255, field = 'Field') => [
  ...requiredRule(field),
  (v) => v.length >= min || `${field} must be at least ${min} characters`,
  (v) => v.length <= max || `${field} must not exceed ${max} characters`,
];

// Masked Number Validation Rule (e.g., ###-##-####-####)
export const prNumberRules = [
  ...requiredRule('PR Number'),
  (v) =>
    /^\d{3}-\d{2}-\d{4}-\d{4}$/.test(v) || 'Format must be ###-##-####-####',
];

// Money Value Validation Rule (not exceeding 99 million, with up to 2 decimal places)
export const prValueRules = [
  ...requiredRule('PR Value'),
  (v) =>
    /^\d{1,8}(\.\d{1,2})?$/.test(v) ||
    'Must be a valid monetary value not exceeding 99 million, with at most 2 decimal places',
  (v) => parseFloat(v) >= 1000 || 'Value must be at least 1000',
  (v) => parseFloat(v) <= 99000000 || 'Value must not exceed 99,000,000',
  (v) =>
    parseFloat(v) === Math.round(parseFloat(v) * 100) / 100 ||
    'Value must be rounded to 2 decimal places',
];

export const dateInRangeRules = (min, max) => [
  ...requiredRule('Event Date/Need'),
  (value) => {
    if (!value) return 'Date is required.';

    const date = dayjs(value);
    const minDate =
      typeof min === 'string'
        ? dayjs().add(min === 'tomorrow' ? 1 : 0, 'day')
        : dayjs(min);
    const maxDate =
      typeof max === 'string' ? dayjs().add(max, 'month') : dayjs(max);

    if (!date.isValid()) {
      return 'Invalid date.';
    }
    if (date.isBefore(minDate)) {
      return `Date must be at least ${minDate.format('YYYY-MM-DD')}.`;
    }
    if (date.isAfter(maxDate)) {
      return `Date must not exceed ${maxDate.format('YYYY-MM-DD')}.`;
    }

    return true;
  },
];
