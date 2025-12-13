const Ziggy = {
    url: 'http:\/\/chrey.test',
    port: null,
    defaults: {},
    routes: {
        'sanctum.csrf-cookie': { uri: 'sanctum\/csrf-cookie', methods: ['GET', 'HEAD'] },
        home: { uri: '\/', methods: ['GET', 'HEAD'] },
        'product.detail': { uri: 'product\/{slug}', methods: ['GET', 'HEAD'], parameters: ['slug'] },
        register: { uri: 'register', methods: ['GET', 'HEAD'] },
        'register.store': { uri: 'register', methods: ['POST'] },
        login: { uri: 'login', methods: ['GET', 'HEAD'] },
        'login.store': { uri: 'login', methods: ['POST'] },
        'cart.index': { uri: 'cart', methods: ['GET', 'HEAD'] },
        'cart.store': { uri: 'cart', methods: ['POST'] },
        'cart.update': { uri: 'cart\/{cart}', methods: ['PUT', 'PATCH'], parameters: ['cart'] },
        'cart.destroy': { uri: 'cart\/{cart}', methods: ['DELETE'], parameters: ['cart'] },
        'api.cart.items': { uri: 'api\/cart\/items', methods: ['GET', 'HEAD'] },
        'orders.index': { uri: 'orders', methods: ['GET', 'HEAD'] },
        'orders.show': {
            uri: 'orders\/{order}',
            methods: ['GET', 'HEAD'],
            parameters: ['order'],
            bindings: { order: 'id' }
        },
        checkout: { uri: 'checkout', methods: ['POST'] },
        logout: { uri: 'logout', methods: ['POST'] },
        'dashboard.index': { uri: 'dashboard', methods: ['GET', 'HEAD'] },
        'dashboard.products.index': { uri: 'dashboard\/products', methods: ['GET', 'HEAD'] },
        'dashboard.products.create': { uri: 'dashboard\/products\/create', methods: ['GET', 'HEAD'] },
        'dashboard.products.store': { uri: 'dashboard\/products', methods: ['POST'] },
        'dashboard.products.show': {
            uri: 'dashboard\/products\/{product}',
            methods: ['GET', 'HEAD'],
            parameters: ['product'],
            bindings: { product: 'id' }
        },
        'dashboard.products.edit': {
            uri: 'dashboard\/products\/{product}\/edit',
            methods: ['GET', 'HEAD'],
            parameters: ['product'],
            bindings: { product: 'id' }
        },
        'dashboard.products.update': {
            uri: 'dashboard\/products\/{product}',
            methods: ['PUT', 'PATCH'],
            parameters: ['product'],
            bindings: { product: 'id' }
        },
        'dashboard.products.destroy': {
            uri: 'dashboard\/products\/{product}',
            methods: ['DELETE'],
            parameters: ['product'],
            bindings: { product: 'id' }
        },
        'dashboard.carts.index': { uri: 'dashboard\/carts', methods: ['GET', 'HEAD'] },
        'dashboard.carts.show': {
            uri: 'dashboard\/carts\/{cart}',
            methods: ['GET', 'HEAD'],
            parameters: ['cart'],
            bindings: { cart: 'id' }
        },
        'dashboard.carts.destroy': {
            uri: 'dashboard\/carts\/{cart}',
            methods: ['DELETE'],
            parameters: ['cart'],
            bindings: { cart: 'id' }
        },
        'dashboard.users.index': { uri: 'dashboard\/users', methods: ['GET', 'HEAD'] },
        'dashboard.users.create': { uri: 'dashboard\/users\/create', methods: ['GET', 'HEAD'] },
        'dashboard.users.store': { uri: 'dashboard\/users', methods: ['POST'] },
        'dashboard.users.show': { uri: 'dashboard\/users\/{user}', methods: ['GET', 'HEAD'], parameters: ['user'] },
        'dashboard.users.edit': {
            uri: 'dashboard\/users\/{user}\/edit',
            methods: ['GET', 'HEAD'],
            parameters: ['user'],
            bindings: { user: 'id' }
        },
        'dashboard.users.update': {
            uri: 'dashboard\/users\/{user}',
            methods: ['PUT', 'PATCH'],
            parameters: ['user'],
            bindings: { user: 'id' }
        },
        'dashboard.users.destroy': {
            uri: 'dashboard\/users\/{user}',
            methods: ['DELETE'],
            parameters: ['user'],
            bindings: { user: 'id' }
        },
        'dashboard.roles.index': { uri: 'dashboard\/roles', methods: ['GET', 'HEAD'] },
        'dashboard.roles.create': { uri: 'dashboard\/roles\/create', methods: ['GET', 'HEAD'] },
        'dashboard.roles.store': { uri: 'dashboard\/roles', methods: ['POST'] },
        'dashboard.roles.show': { uri: 'dashboard\/roles\/{role}', methods: ['GET', 'HEAD'], parameters: ['role'] },
        'dashboard.roles.edit': {
            uri: 'dashboard\/roles\/{role}\/edit',
            methods: ['GET', 'HEAD'],
            parameters: ['role'],
            bindings: { role: 'id' }
        },
        'dashboard.roles.update': {
            uri: 'dashboard\/roles\/{role}',
            methods: ['PUT', 'PATCH'],
            parameters: ['role'],
            bindings: { role: 'id' }
        },
        'dashboard.roles.destroy': {
            uri: 'dashboard\/roles\/{role}',
            methods: ['DELETE'],
            parameters: ['role'],
            bindings: { role: 'id' }
        },
        'storage.local': {
            uri: 'storage\/{path}',
            methods: ['GET', 'HEAD'],
            wheres: { path: '.*' },
            parameters: ['path']
        }
    }
}
if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes)
}
export { Ziggy }
