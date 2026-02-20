/**
 * Helper to resolve the correct URL for a tenant's site.
 * Handles both local development (path-based: /username/page) 
 * and production (subdomain-based: username.domain.com/page).
 * 
 * @param username The tenant's username
 * @param path The relative path (e.g. '', '/', 'products', '/post/slug')
 * @returns The resolved URL string
 */
export function getDomainUrl(username: string, path: string = ''): string {
    if (typeof window === 'undefined') {
        // SSR Fallback (assuming path-based if SSR doesn't inject host, though Inertia SSR usually sets ziggy)
        const normalizedPath = path.startsWith('/') ? path : `/${path}`;
        return normalizedPath === '/' ? `/${username}` : `/${username}${normalizedPath}`;
    }

    const hostname = window.location.hostname;
    const normalizedPath = path.startsWith('/') ? path : `/${path}`;

    // If the hostname starts with the username (e.g. username.kotaukir.id)
    const isSubdomain = hostname.startsWith(`${username}.`);

    if (isSubdomain) {
        return normalizedPath === '/' ? '/' : normalizedPath;
    }

    // Fallback: Path-based routing for local dev (e.g. localhost/username/path)
    if (normalizedPath === '/') {
        return `/${username}`;
    }

    return `/${username}${normalizedPath}`;
}
