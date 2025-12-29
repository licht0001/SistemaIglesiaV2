// Settings service with API + localStorage cache
import api from './api';

const STORAGE_KEY = 'app_settings';

const defaultSettings = {
  churchName: 'Iglesia',
  denomination: '',
  address: '',
  phone: '',
  email: '',
  website: '',
  currency: 'Bolivianos (Bs)',
  timezone: 'America/La_Paz',
  messaging: {
    countryPrefix: '591',
    birthdayTemplate: '¡Feliz cumpleaños, {nombre}! Que Dios te bendiga en este nuevo año. — {iglesia}',
  },
  notifications: {
    emailEnabled: true,
    whatsappEnabled: true,
    newMemberAlert: true,
    newTransactionAlert: false,
    monthlyReportAlert: true,
  },
  security: {
    sessionTimeout: 120, // minutes
    failedAttemptsLimit: 5,
    passwordCompliance: 'medium',
    twoFactorAuth: false,
    maintenanceMode: false,
  },
  database: {
    autoBackup: true,
    backupFrequency: 'weekly',
    lastBackup: null,
  }
};

export function getAppSettings() {
  try {
    const raw = localStorage.getItem(STORAGE_KEY);
    if (!raw) return { ...defaultSettings };
    const parsed = JSON.parse(raw);
    return mergeDefaults(parsed, defaultSettings);
  } catch {
    return { ...defaultSettings };
  }
}

export function saveAppSettings(partial) {
  const current = getAppSettings();
  const next = deepMerge(current, partial);
  localStorage.setItem(STORAGE_KEY, JSON.stringify(next));
  return next;
}

function mergeDefaults(target, defaults) {
  if (Array.isArray(defaults) || Array.isArray(target)) return target ?? defaults;
  if (typeof defaults === 'object' && defaults !== null) {
    const out = { ...defaults, ...(target || {}) };
    for (const k of Object.keys(defaults)) {
      if (typeof defaults[k] === 'object') {
        out[k] = mergeDefaults(target?.[k], defaults[k]);
      }
    }
    return out;
  }
  return target ?? defaults;
}

export async function fetchSettingsApi() {
  try {
    const { data } = await api.get('/settings');
    const merged = mergeDefaults(data, defaultSettings);
    localStorage.setItem(STORAGE_KEY, JSON.stringify(merged));
    return merged;
  } catch (e) {
    return getAppSettings();
  }
}

export async function saveSettingsApi(payload) {
  const { data } = await api.put('/settings', payload);
  const merged = mergeDefaults(data, defaultSettings);
  localStorage.setItem(STORAGE_KEY, JSON.stringify(merged));
  return merged;
}

// Landing Page Settings functions
export async function fetchLandingSettings() {
  const { data } = await api.get('/settings/landing');
  return data;
}

export async function updateLandingSettings(payload) {
  const { data } = await api.put('/settings/landing', payload);
  return data;
}

export async function fetchLandingSettingsPublic() {
  const { data } = await api.get('/settings/landing');
  return data;
}

function deepMerge(base, extra) {
  if (Array.isArray(base) && Array.isArray(extra)) return extra;
  if (typeof base === 'object' && base !== null && typeof extra === 'object' && extra !== null) {
    const out = { ...base };
    for (const k of Object.keys(extra)) {
      out[k] = deepMerge(base[k], extra[k]);
    }
    return out;
  }
  return extra ?? base;
}
