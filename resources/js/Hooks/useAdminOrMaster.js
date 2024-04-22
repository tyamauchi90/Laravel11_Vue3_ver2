import { computed } from 'vue';

export function useAdminOrMaster(userRole) {
  const isAdminOrMaster = computed(() => {
    return userRole === 'admin' || userRole === 'master';
  });

  return { isAdminOrMaster };
}
