import { computed } from 'vue';

export function useMaster(userRole) {
  const isMaster = computed(() => {
    return userRole === 'master';
  });

  return { isMaster };
}
